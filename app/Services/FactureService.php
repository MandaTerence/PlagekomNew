<?php

namespace App\Services;

use App\Models\Utilisateur;
use Illuminate\Support\Str;

class FactureService {

    const MIN_COMMERCIAUX = 7;
    const MAX_COMMERCIAUX = 8;

    public function __construct()
    {
        //
    }

    public static function test(){
        return "ok test";
    }

    public static function generatePlanning($idMission,$coach){
        $personnels = DetailMission::getPersonnelFromCoach($coach,$idMission);
        $classement = Classement::getFromMatricules($idMission,$personnels);
        $mission = Mission::getFirst([['Id_de_la_mission','like',$idMission]]);
        $Date_depart = $mission->Date_depart;
        $Date_de_fin = $mission->Date_de_fin;
        $period = new DatePeriod(
            new DateTime($Date_depart),
            new DateInterval('P1D'),
            new DateTime($Date_de_fin)
       );
       return $period;
    }

}