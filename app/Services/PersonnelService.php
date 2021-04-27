<?php

namespace App\Services;

use App\Interfaces\CustomAuthService;
use App\Models\Personnel;
use App\Models\Classement;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

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

    public static function getAllFromMission($jour='%'){
        $result = [];
        $missions = DB::table("mission")
        ->where("statut","En_cours")
        ->get();
        foreach($missions as $mission){
            $result[] = self::getFromMission($mission->Id_de_la_mission,$jour);
        }
        return $result;
    }

    public static function getFromMission($idMission,$jour='%'){
        $commerciaux = [];
        $coach = [];
        $ville ="inconnue";
        $resSql= DB::table("planing")
        ->select("Ville_d_annimation")
        ->where("Id_de_la_mission",$idMission)
        ->where("date",$jour)
        ->first();
        if(isset($resSql)){
            $ville = $resSql->Ville_d_annimation;
        }
        else{
            $ville = DB::table("planing")
            ->select("Ville_d_annimation")
            ->where("Id_de_la_mission",$idMission)
            ->orderBy("Date","DESC")
            ->first()->Ville_d_annimation;
        }
        $equipe = DB::table("equipe_temporaire")
        ->where("Id_de_la_mission",$idMission)
        ->get();
        foreach($equipe as $eq){
            if($eq->type == "Coach"){
                $personne = new Personnel();
                $personne->Matricule = $eq->matricule_personnel;
                $personne->getDetailSanction($jour);
                $personne->getDetailControl($jour);
                $coach[] = $personne;
            }
            else if($eq->type == "Commerciaux"){
                $personne = new Personnel(); 
                $personne->Matricule = $eq->matricule_personnel;
                $personne->getDetailSanction($jour);
                $personne->getDetailControl($jour);
                $commerciaux[] = $personne;
            }
        }
        return [
            "idMission" => $idMission,
            "ville" => $ville,
            "Commerciaux" => $commerciaux,
            "Coach" => $coach
        ];
    }

    public static function saveEquipeTemp($commerciaux,$coach,$idMission){
        try{
            DB::table('equipe_temporaire')->insert([
                'Id_de_la_mission' => $idMission,
                'matricule_personnel' => $coach,
                'type' => 'Coach',
            ]);
            foreach($commerciaux as $com){
                DB::table('equipe_temporaire')->insert([
                    'Id_de_la_mission' => $idMission,
                    'matricule_personnel' => $com["Matricule"],
                    'type' => 'Commerciaux',
                ]);
            }
            return true;
        }catch(QueryException $e){
            return false;
        }
    }
}