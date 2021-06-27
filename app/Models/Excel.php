<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Accompagnement;
use App\Models\Personnel;
use App\Models\Mission;
use App\Models\DetailMission;
use App\Helpers\ControllerHelper;
use Illuminate\Support\Facades\DB;
use App\Services\ClassementService;
use App\Services\PersonnelService;
use App\Services\AccompagnementService;

class Excel extends Model
{
    const DEFAULT_MAX_RESULT = 10;

    const DEFAULT_COEF = [
        'global' => 5,
        'local' => 2,
        'mission' => 1,
        'produitPlusCher' => 1,
        'produitMoinsCher' => 1,
        'produit' => []
    ];
    const DATE_JOUR = [
        'Lundi',
        'Lundi',
        'Mardi',
        'Mercredi',
        'Jeudi',
        'Vendredi',
        'Samedi',
        'Dimanche'
    ];

    public static function check($lien)
    {
        $lien = substr($lien, 5);
        $data = json_decode($lien);
        
        if($data->excel=="evaluation"){
            self::getEvaluation($data);
        }
        else if($data->excel=="Planning"){
            self::getPlanning($data);
        }
/*
        $excel = "";
        $excel .=  "Code client\tNum Commande\tClient\tDate de Commande\tDate de Livraison\tLien Facebook\tContact\tProduit\tPU\tQTT\tlieu de livraison\tOPL\tQuartier\tVille\tMontant\tLocalisation\tFrais\tRemarque\tStatut\n";

        header("Content-type: application/vnd.ms-excel");
        header("Content-disposition: attachment; filename=evaluation.xls");

        print $excel;
        exit;
*/
    }

    public static function getPlanning($data){
        $idMission = $data->idMission;
        $coachs = Accompagnement::getCoachsFromMission($idMission);
        $accParJour = [];
        $mission = Mission::getFirst([["Id_de_la_mission",$idMission]]);
        $depart = $mission->Date_depart;
        $fin = $mission->Date_de_fin;
        if(isset($coachs)){
            foreach($coachs as $coach){
                $acc = Accompagnement::getFromMissionAndCoach($idMission,$coach->Coach);
                $accParJour[] = [
                    "coach"=>$coach,
                    "accompagnement"=>AccompagnementService::toFormatParJour($acc)
                ];
            }
        }
        $accParJour;
        $excel = "\t\t PLANNING D'ACCOMPAGNEMENT ".$idMission."\n\n";
        $excel .= "ACCOMPAGNEMENT - MATIN\t\tHeure de debut\t08:30:00\t10:30:00\t08:30:00\t10:30:00\n";
        $excel .= "\t\tHeure de fin\t10:00:00\t12:00:00\t10:00:00\t12:00:00\n";
        $excel .= "ACCOMPAGNEMENT - APRES MIDI\t\tHeure de debut\t14:30:00\t16:30:00\t14:30:00\t16:30:00\n";
        $excel .= "\t\tHeure de fin\t16:00:00\t18:00:00\t16:00:00\t18:00:00\n\n";
        $excel .= "DATE DE LA MISSION\t\tDate de depart\t".$depart."\t".$depart."\t".$depart."\t".$depart."\n";
        $excel .= "\t\tDate de fin\t".$fin."\t".$fin."\t".$fin."\t".$fin."\n\n";
        foreach($accParJour as $acc){
            $excel .= "Coach\t\t".$acc["coach"]->Coach."\n";
            foreach($acc["accompagnement"] as $plan){
                $d = date('w', strtotime($plan["jour"]));
                $date = self::getDate($d);
                $mat1 = $plan["matin"][0]["Commercial"];
                $mat2 = $plan["matin"][1]["Commercial"];
                $ap1 = $plan["apresMidi"][0]["Commercial"];
                $ap2 = $plan["apresMidi"][1]["Commercial"];
                $excel .= $date."\t".$plan["jour"]."\t".$idMission."\t".$mat1."\t".$mat2."\t".$ap1."\t".$ap2."\n";
            }
        }
        header("Content-disposition: attachment; filename=plannings.xls");
        print $excel;
    }

    public static function getDate($d){
        return self::DATE_JOUR[$d];
    }

    public static function getEvaluation($data){
        $equipeA = [];
        $excel = $data->excel;
        $Matricules= $data->Matricules;
        $Produits= $data->Produits;
        
        $dateDebut= $data->dateDebut;
        $dateFin= $data->dateFin;

        $listeDateExclu= $data->listeDateExclu;

        $pourcentage= $data->pourcentage;
        $minimumVente= $data->minimumVente;

        $interval = getDateInterval(30);

        $equipeA = PersonnelService::getPersonnelFromMatricule($Matricules);

        if((isset($dateDebut))&&(isset($dateFin))){
            $interval = (object) [
                "lastDate" => $dateFin,
                "firstDate" => $dateDebut
            ];
        }

        $jourDeTravail = PersonnelService::getJourTravail($interval,$listeDateExclu);
        $equipe = [];

        foreach($equipeA as $personnel){
            $personnel->getAllCA($interval,$listeDateExclu);
            $personnel->getNbrJourObjectifAtteint($interval,$minimumVente,$listeDateExclu);
            $personnel->getPourcentageObjectif($jourDeTravail);
            $personnel->getNbrProduit($interval);
            $personnel->getStatutbimestriel();
            $personnel->getAssuidite();
        }
        
        $classement = ClassementService::getEvaluation($equipeA,self::DEFAULT_COEF,$interval,$minimumVente,$listeDateExclu,$pourcentage);
        $excel = "\tPlace\tMatricule\tNom et Prenom\tCA Mission\tCA Local\tCA Total\tratio de vente\tassuidite\tstatut\n";
        foreach($classement as $personnel){
            $excel .= "\t$personnel->place\t$personnel->Matricule\t$personnel->Nom $personnel->Prenom\t$personnel->CAMission\t$personnel->CALocal\t$personnel->CAGlobal\t".number_format($personnel->pourcentageObjectif, 2, '.', '')."\t".number_format($personnel->assuidite, 2, '.', '')."\t$personnel->etatVente\n";
        }
        //header("Content-type: application/vnd.ms-excel");
        header("Content-disposition: attachment; filename=evaluation.xls");
        print $excel;
    }
}
