<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Personnel;
use App\Models\DetailMission;
use App\Helpers\ControllerHelper;
use Illuminate\Support\Facades\DB;
use App\Services\ClassementService;
use App\Services\PersonnelService;

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

    public static function check($lien)
    {
        $lien = substr($lien, 5);
        $data = json_decode($lien);
        
        if($data->excel=="evaluation"){
            self::getEvaluation($data);
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
