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
        'Dimanche',
        'Lundi',
        'Mardi',
        'Mercredi',
        'Jeudi',
        'Vendredi',
        'Samedi',
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
        else if($data->excel=="controlMission"){
            self::getControlMission($data);
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

    public static function getControlMission($data){
        $missions = PersonnelService::getAllFromMission($data->jour);
        $excel = "";
        foreach($missions as $mission){
            if($mission->Id_de_la_mission == $data->idMission){
                $excel .="\n";
                $excel .= "\t\t Mission: \t ".$idMission."\n\n";
                $excel .= "nbr de commerciaux\t".count($mission->Commerciaux)."\tVille d animation\t".$mission->ville."\n\n";
                $excel .= "Matricule\tHeure de controle\tVille d animation\tDuree de controle\tcode de sanction\tCA sanction\tEtat Controle\taction\n";
                $excel .= "";
            }
        }
        header("Content-disposition: attachment; filename=control.xls");
        print $excel;
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
                $acc = AccompagnementService::toFormatParJour($acc);
                $acc = AccompagnementService::completeSunday($acc);
                $accParJour[] = [
                    "coach"=>$coach,
                    "accompagnement"=>$acc
                ];
            }
        }
        $excel = "\t\t PLANNING D'ACCOMPAGNEMENT ".$idMission."\n\n";
        $excel .= "ACCOMPAGNEMENT - MATIN\t\tHeure de debut\t08:30:00\t10:30:00\t08:30:00\t10:30:00\n";
        $excel .= "\t\tHeure de fin\t10:00:00\t12:00:00\t10:00:00\t12:00:00\n";
        $excel .= "ACCOMPAGNEMENT - APRES MIDI\t\tHeure de debut\t14:30:00\t16:30:00\t14:30:00\t16:30:00\n";
        $excel .= "\t\tHeure de fin\t16:00:00\t18:00:00\t16:00:00\t18:00:00\n\n";
        $excel .= "DATE DE LA MISSION\t\tDate de depart\t".$depart."\t".$depart."\t".$depart."\t".$depart."\n";
        $excel .= "\t\tDate de fin\t".$fin."\t".$fin."\t".$fin."\t".$fin."\n\n";

        foreach($accParJour as $acc){
            $excel .= "Coach\t\t".$acc["coach"]->Coach."\t\t\t\t\n";
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

    public static function getPlanningOld($data){
        $idMission = $data->idMission;
        $coachs = Accompagnement::getCoachsFromMission($idMission);
        $accParJour = [];
        $mission = Mission::getFirst([["Id_de_la_mission",$idMission]]);
        $depart = $mission->Date_depart;
        $fin = $mission->Date_de_fin;
        if(isset($coachs)){
            foreach($coachs as $coach){
                $acc = Accompagnement::getFromMissionAndCoach($idMission,$coach->Coach);
                $acc = AccompagnementService::toFormatParJour($acc);
                $acc = AccompagnementService::completeSunday($acc);
                $accParJour[] = [
                    "coach"=>$coach,
                    "accompagnement"=>$acc
                ];
            }
        }
        $excel = "\t\t PLANNING D'ACCOMPAGNEMENT ".$idMission."\n\n";
        $excel .= "ACCOMPAGNEMENT - MATIN\t\tHeure de debut\t08:30:00\t10:30:00\t08:30:00\t10:30:00\n";
        $excel .= "\t\tHeure de fin\t10:00:00\t12:00:00\t10:00:00\t12:00:00\n";
        $excel .= "ACCOMPAGNEMENT - APRES MIDI\t\tHeure de debut\t14:30:00\t16:30:00\t14:30:00\t16:30:00\n";
        $excel .= "\t\tHeure de fin\t16:00:00\t18:00:00\t16:00:00\t18:00:00\n\n";
        $excel .= "DATE DE LA MISSION\t\tDate de depart\t".$depart."\t".$depart."\t".$depart."\t".$depart."\n";
        $excel .= "\t\tDate de fin\t".$fin."\t".$fin."\t".$fin."\t".$fin."\n\n";
        $excelRow = [
            "date" => "aucun",
            "row" => "Coach\t\t"
        ];

        foreach($accParJour as $acc){
            $excelRow[0]["row"] .=$acc["coach"]->Coach."\t\t\t\t";
        }
        $excelRow[0]["row"] .="\n";

        foreach($accParJour[0]["accompagnement"] as $acc){
            $excelRow[] = $plan["jour"];
            $d = date('w', strtotime($plan["jour"]));
            $date = self::getDate($d);
            $excelRow[] = [
                "date" => $plan["jour"],
                "row" =>$date."\t".$plan["jour"]."\t"
            ];
        }
        foreach($excelRow as $row){
            foreach($accParJour as $acc){
                foreach($acc["accompagnement"] as $plan){
                    if($plan["jour"]==$row["date"]){

                        $d = date('w', strtotime($plan["jour"]));
                        $date = self::getDate($d);
                        $mat1 = $plan["matin"][0]["Commercial"];
                        $mat2 = $plan["matin"][1]["Commercial"];
                        $ap1 = $plan["apresMidi"][0]["Commercial"];
                        $ap2 = $plan["apresMidi"][1]["Commercial"];

                        $row["row"] .="\t".$idMission."\t".$mat1."\t".$mat2."\t".$ap1."\t".$ap2."\n";

                        break;
                    }
                }
            }
        }
        foreach($accParJour as $acc){
            $excel .= "Coach\t\t".$acc["coach"]->Coach."\t\t\t\t\n";
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
            $personnel->getNbrJourObjectifAtteint($interval,$listeDateExclu);
            $personnel->getPourcentageObjectif($jourDeTravail);
            $personnel->getNbrProduit($interval);
            $personnel->getStatutbimestriel();
            $personnel->getAssuidite();
            $personnel->getCAMoyen();
        }
        
        $classement = ClassementService::getEvaluation($equipeA,self::DEFAULT_COEF,$interval,$minimumVente,$listeDateExclu,$pourcentage);
        $excel = "\tPlace\tMatricule\tNom et Prenom\tCA Mission\tCA Local\tCA Total\tCA Moyen\tratio de vente\tassuidite\tstatut\n";
        foreach($classement as $personnel){

            $personnel->CAMoyen = (int)$personnel->CAMoyen;

            $excel .= "\t$personnel->place\t$personnel->Matricule\t$personnel->Nom $personnel->Prenom\t$personnel->CAMission\t$personnel->CALocal\t$personnel->CAGlobal\t$personnel->CAMoyen\t".number_format($personnel->pourcentageObjectif, 2, '.', '')."\t".number_format($personnel->assuidite, 2, '.', '')."\t$personnel->etatVente\n";
        }
        //header("Content-type: application/vnd.ms-excel");
        header("Content-disposition: attachment; filename=evaluation.xls");
        print $excel;
    }
}
