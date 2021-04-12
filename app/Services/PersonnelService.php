<?php

namespace App\Services;

use App\Interfaces\CustomAuthService;
use App\Models\Personnel;
use Illuminate\Support\Str;

class PersonnelService {

    public static function getPersonnelFromMatricule($matricules){
        $personnels = [];
        foreach($matricules as $matricule){
            $personnel = new Personnel;
            $personnel->Matricule = $matricule;
            $personnel->getNomFromMAtricule();
            $personnels[] = $personnel;
        }
        return $personnels;
    }

    public static function getCATotal($matricules,$produits){
        $personnels = [];
        foreach($matricules as $matricule){
            $personnel = new Personnel;
            $personnel->Matricule = $matricule;
            $personnel->CAGlobal = $personnel->getCAGlobal();
            $personnel->CAGlobal = $personnel->getPersonnelsCALocal();
        }
        return $personnels;
    }

    public static function getPersonnelsCAProduit($matricules,$produit){
        $personnels = [];
        foreach($matricules as $matricule){
            $personnel = new Personnel;
            $personnel->Matricule = $matricule;
            $personnel->CAProduit = $personnel->getCAselonProduit($produit);
            $personnels[] = $personnel;
        }
        return $personnels;
    }

    public static function getPersonnelsCAGlobal($matricules){
        $personnels = [];
        foreach($matricules as $matricule){
            $personnel = new Personnel;
            $personnel->Matricule = $matricule;
            $personnel->CAGlobal = $personnel->getCAGlobal();
            $personnels[] = $personnel;
        }
        return $personnels;
    }

    public static function getPersonnelsCALocal($matricules){
        $personnels = [];
        foreach($matricules as $matricule){
            $personnel = new Personnel;
            $personnel->Matricule = $matricule;
            $personnel->CAGlobal = $personnel->getCAGlobal();
            $personnels[] = $personnel;
        }
        return $personnels;
    }

    public static function getPersonnelsCAMission($matricules){
        $personnels = [];
        foreach($matricules as $matricule){
            $personnel = new Personnel;
            $personnel->Matricule = $matricule;
            $personnel->CAMission = $personnel->getCAMission();
            $personnels[] = $personnel;
        }
        return $personnels;
    }

}