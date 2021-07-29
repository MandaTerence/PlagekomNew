<?php

namespace App\Services;

use App\Interfaces\CustomAuthService;
use App\Models\Personnel;
use App\Models\Classement;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class PersonnelService {

    const pourCentSalaire = 15;

    public static function getJourTravail($interval="",$dateExclu=[]){
        if($interval==""){
            return 0;
        }
        else{
            $jourTravail = DB::table("facture")
            ->selectRaw("coalesce(count(distinct Date),0) as jourTravail")
            ->whereBetween('facture.Date', [$interval->firstDate,$interval->lastDate]);
            foreach($dateExclu as $date){
                $jourTravail->whereRaw("facture.Date != '".$date."' ");
            }
            return $jourTravail->first()->jourTravail;
        }
    }

    public static function getPersonnelsMission($type){
        /*
         select distinct 
                detailmission.personnel as Matricule
            from mission 
            JOIN detailmission
                on detailmission.Id_de_la_mission = mission.Id_de_la_mission
            where statut like 'En_cours'
            AND Type_de_mission like 'LOCAL'
        */
        $personnels = [];
        $matricules =  DB::table("mission")
        ->select("detailmission.personnel as Matricule")
        ->distinct()
        ->join("detailmission","detailmission.Id_de_la_mission","=","mission.Id_de_la_mission")
        ->where("mission.statut","En_cours")
        ->where("mission.Type_de_mission",$type)
        ->get();
        foreach($matricules as $matricule){
            $personnel = new Personnel;
            $personnel->Matricule = $matricule->Matricule;
            $personnels[] = $personnel;
        }
        return $personnels;
    }

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

    public static function getAllSalaire($mois,$annee){
        $personnels = self::getPersonnelFromDate($mois,$annee);
        $malus = Personnel::getMalus();
        foreach($personnels as $personnel){
            $personnel->getNomFromMAtricule();
            $personnel->getSalaire($mois,$annee,$malus);
        }
        return $personnels;
    }

    public static function getPersonnelFromDate($mois,$annee){
        $matricules = DB::table("facture")
        ->select("Matricule_personnel as matricule")
        ->whereRaw("Matricule_personnel not like 'C%' ")
        ->whereRaw("MONTH(date) = ".$mois."")
        ->whereRaw("YEAR(date) = ".$annee."")
        ->distinct()
        ->get();
        $personnels = [];
        foreach($matricules as $matricule){
            $p = new Personnel;
            $p->Matricule = $matricule->matricule;
            $personnels[] = $p;
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
        //->where("statut","En_cours")
        ->whereRaw("mission.Date_depart >= '".$jour."'")
        ->whereRaw("mission.Date_de_fin <= '".$jour."'")
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
        else{/*
            $ville = DB::table("planing")
            ->select("Ville_d_annimation")
            ->where("Id_de_la_mission",$idMission)
            ->orderBy("Date","DESC")
            ->first()->Ville_d_annimation;
            */
        }
        $equipe = DB::table("equipe_temporaire")
        ->where("equipe_temporaire.Id_de_la_mission",$idMission)
        ->join("mission","mission.Id_de_la_mission","equipe_temporaire.Id_de_la_mission")
        ->whereRaw("mission.Date_depart >= '".$jour."'")
        ->whereRaw("mission.Date_de_fin <= '".$jour."'")
        ->get();

        /*  
            select * from mission where mission.Date_depart >= '2021-08-31' AND mission.Date_depart >= '2021-08-31'
         
         */

        if(count($equipe)>1){
            foreach($equipe as $eq){
                if($eq->type == "Coach"){
                    $personne = new Personnel();
                    $personne->Matricule = $eq->matricule_personnel;
                    $personne->getDetailSanction($jour);
                    $personne->getDetailControl($jour);
                    $personne->getNomFromMAtricule();
                    $coach[] = $personne;
                }
                else if($eq->type == "Commerciaux"){
                    $personne = new Personnel(); 
                    $personne->Matricule = $eq->matricule_personnel;
                    $personne->getDetailSanction($jour);
                    $personne->getDetailControl($jour);
                    $personne->getNomFromMAtricule();
                    $commerciaux[] = $personne;
                }
            }
        }

        else{
            $matricules = DB::table("detailMission")
            ->join("mission","mission.Id_de_la_mission","detailMission.Id_de_la_mission")
            ->select("personnel")
            ->whereRaw("mission.Date_depart >= '".$jour."'")
            ->whereRaw("mission.Date_de_fin <= '".$jour."'")
            ->where("detailMission.Id_de_la_mission",$idMission)
            ->get();

            foreach($matricules as $matricule){
                if(str_starts_with($matricule->personnel,'COTN')){
                    $personne = new Personnel();
                    $personne->Matricule = $matricule->personnel;
                    $personne->getDetailSanction($jour);
                    $personne->getDetailControl($jour);
                    $personne->getNomFromMAtricule();
                    $coach[] = $personne;
                }
                else {
                    $personne = new Personnel(); 
                    $personne->Matricule = $matricule->personnel;
                    $personne->getDetailSanction($jour);
                    $personne->getDetailControl($jour);
                    $personne->getNomFromMAtricule();
                    $commerciaux[] = $personne;
                }
            }
            
        }

        return [
            "idMission" => $idMission,
            "Commerciaux" => $commerciaux,
            "Coach" => $coach,
            "jour" => $jour,
            "ville" => $ville
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