<?php

namespace App\Services;

use App\Models\Personnel;
use App\Models\Classement;
use App\Services\PersonnelService;

class ClassementService {

    const DEFAULT_COEF = [
        'global' => 5,
        'local' => 2,
        'mission' => 1,
        'produitPlusCher' => 1,
        'produitMoinsCher' => 1,
        'produit' => [],
        'typeMission' => 1
    ];

    public static function compareCATotal($pa,$pb){
        if ($pa->CATotal == $pb->CATotal) { 
            return 0;
        }
        return ($pa->CATotal > $pb->CATotal) ? -1 : 1;
    }
    
    public static function compareCAProduitMoinsCher($pa,$pb){
        if ($pa->CAProduitMoinsCher == $pb->CAProduitMoinsCher) { 
            return 0;
        }
        return ($pa->CAProduitMoinsCher > $pb->CAProduitMoinsCher) ? -1 : 1;
    }

    public static function compareCAProduitPlusCher($pa,$pb){
        if ($pa->CAProduitPlusCher == $pb->CAProduitPlusCher) { 
            return 0;
        }
        return ($pa->CAProduitPlusCher > $pb->CAProduitPlusCher) ? -1 : 1;
    }

    public static function compareCAGlobal($pa,$pb){
        if ($pa->CAGlobal == $pb->CAGlobal) { 
            return 0;
        }
        return ($pa->CAGlobal > $pb->CAGlobal) ? -1 : 1;
    }

    public static function compareCAMission($pa,$pb){
        if ($pa->CAMission == $pb->CAMission) { 
            return 0;
        }
        return ($pa->CAMission > $pb->CAMission) ? -1 : 1;
    }

    public static function compareCALocal($pa,$pb){
        if ($pa->CALocal == $pb->CALocal) { 
            return 0;
        }
        return ($pa->CALocal > $pb->CALocal) ? -1 : 1;
    }

    public static function compareCAProduit($pa,$pb){
        if ($pa->CAProduit == $pb->CAProduit) { 
            return 0;
        }
        return ($pa->CAProduit > $pb->CAProduit) ? -1 : 1;
    }

    public static function getEvaluationSelonTypeMission($idType,$personnels,$coef=self::DEFAULT_COEF,$interval="",$dateXclu=[],$taux=0){
        foreach($personnels as $personnel){
            $personnel->getCATotal($coef);
        }
        usort($personnels,'static::compareCATotal');
        $personnelsFinal = [];
        $personnelsNonQualifier = [];
        for($i=0;$i<count($personnels);$i++){
            if($personnels[$i]->pourcentageObjectif>=$taux){
                $personnels[$i]->place = $i+1;
                $personnels[$i]->etatVente = "Qualifier";
                $personnelsFinal[] = $personnels[$i];
            }
            else{
                $personnelsNonQualifier[] = $personnels[$i];
            }
        }
        $placeActuelle = count($personnelsFinal)+1;
        for($i=0;$i<count($personnelsNonQualifier);$i++,$placeActuelle++){
            $personnelsNonQualifier[$i]->etatVente = "Non qualifier";
            $personnelsNonQualifier[$i]->place = $placeActuelle;
            $personnelsFinal[] = $personnelsNonQualifier[$i];
        }
        return $personnelsFinal;
    }

    public static function getEvaluation($personnels,$coef=self::DEFAULT_COEF,$interval="",$dateXclu=[],$taux=0,$idType=""){
        foreach($personnels as $personnel){
            $personnel->getCATotal($coef);
        }
        usort($personnels,'static::compareCATotal');
        $personnelsFinal = [];
        $personnelsNonQualifier = [];
        for($i=0;$i<count($personnels);$i++){
            if($personnels[$i]->pourcentageObjectif>=$taux){
                $personnels[$i]->place = $i+1;
                $personnels[$i]->etatVente = "Qualifier";
                $personnelsFinal[] = $personnels[$i];
            }
            else{
                $personnelsNonQualifier[] = $personnels[$i];
            }
        }
        $placeActuelle = count($personnelsFinal)+1;
        for($i=0;$i<count($personnelsNonQualifier);$i++,$placeActuelle++){
            $personnelsNonQualifier[$i]->etatVente = "Non qualifier";
            $personnelsNonQualifier[$i]->place = $placeActuelle;
            $personnelsFinal[] = $personnelsNonQualifier[$i];
        }
        return $personnelsFinal;
    }

    public static function getClassementTotal($p,$coef=self::DEFAULT_COEF){
        $personnels = $p;
        foreach($personnels as $personnel){
            $personnel->getCATotal($coef);
        }
        usort($personnels,'static::compareCATotal');
        $personnelsFinal = [];
        for($i=0;$i<count($personnels);$i++){
            $personnels[$i]->place = $i+1;
            $personnels[$i]->getCAMoyen();
            $personnelsFinal[] = $personnels[$i];
        }
        return $personnelsFinal;
    }

    public static function getClassementGlobal($p){
        $personnels = $p;
        usort($personnels,'static::compareCAGlobal');
        $personnelsFinal = [];
        for($i=0;$i<count($personnels);$i++){
            $personnels[$i]->place = $i+1;
            $personnelsFinal[] = [
                "Matricule"=>$personnels[$i]->Matricule,
                "Nom"=>$personnels[$i]->Nom."".$personnels[$i]->Prenom,
                "place"=>$personnels[$i]->place,
                "CA"=>$personnels[$i]->CAGlobal
            ];
        }
        return $personnelsFinal;
    }

    public static function getClassementLocal($p){
        $personnels = $p;
        usort($personnels,'static::compareCALocal');
        $personnelsFinal = [];
        for($i=0;$i<count($personnels);$i++){
            $personnels[$i]->place = $i+1;
            $personnelsFinal[] = [
                "Matricule"=>$personnels[$i]->Matricule,
                "Nom"=>$personnels[$i]->Nom."".$personnels[$i]->Prenom,
                "place"=>$personnels[$i]->place,
                "CA"=>$personnels[$i]->CALocal
            ];
        }
        return $personnelsFinal;
    }

    public static function getClassementProduitPlusCher($p){
        $personnels = $p;
        usort($personnels,'static::compareCAProduitPlusCher');
        $personnelsFinal = [];
        for($i=0;$i<count($personnels);$i++){
            $personnels[$i]->place = $i+1;
            $personnelsFinal[] = [
                "Matricule"=>$personnels[$i]->Matricule,
                "Nom"=>$personnels[$i]->Nom."".$personnels[$i]->Prenom,
                "place"=>$personnels[$i]->place,
                "CA"=>$personnels[$i]->CAProduitPlusCher
            ];
        }
        return $personnelsFinal;
    }

    public static function getClassementProduitMoinsCher($p){
        $personnels = $p;
        usort($personnels,'static::compareCAProduitMoinsCher');
        $personnelsFinal = [];
        for($i=0;$i<count($personnels);$i++){
            $personnels[$i]->place = $i+1;
            $personnelsFinal[] = [
                "Matricule"=>$personnels[$i]->Matricule,
                "Nom"=>$personnels[$i]->Nom."".$personnels[$i]->Prenom,
                "place"=>$personnels[$i]->place,
                "CA"=>$personnels[$i]->CAProduitMoinsCher
            ];
        }
        return $personnelsFinal;
    }

    public static function getClassementMission($p){
        $personnels = $p;
        usort($personnels,'static::compareCAMission');
        $personnelsFinal = [];
        for($i=0;$i<count($personnels);$i++){
            $personnels[$i]->place = $i+1;
            $personnelsFinal[] = [
                "Matricule"=>$personnels[$i]->Matricule,
                "Nom"=>$personnels[$i]->Nom."".$personnels[$i]->Prenom,
                "place"=>$personnels[$i]->place,
                "CA"=>$personnels[$i]->CAMission
            ];
        }
        return $personnelsFinal;
    }

    public static function getClassementProduit($personnels,$produit){
        $personnels = PersonnelService::getPersonnelsCAProduit($matricules,$produit);
        usort($personnels,'static::compareCAProduit');
        for($i=0;$i<count($personnels);$i++){
            $personnels[$i]->place = $i+1;
        }
        return $personnels;
    }
    
    public static function getClassementProduits($personnels,$produit){
        $personnels = PersonnelService::getPersonnelsCAProduit($matricules,$produit);
        usort($personnels,'static::compareCAProduit');
        for($i=0;$i<count($personnels);$i++){
            $personnels[$i]->place = $i+1;
        }
        return $personnels;
    }

}