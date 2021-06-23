<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Classement;
use App\Models\Accompagnement;
use App\Models\DetailMission;
use Illuminate\Http\Request;
use App\Services\AccompagnementService;
use App\Services\PersonnelService;

class ClassementController extends Controller
{
    public function create(Request $request){
        $coach = $request->input('matriculeCoach');
        $commerciaux = $request->input('matriculeCommerciaux');
        $idMission = $request->input('idMission');
        
        $success = Classement::saveFromCommerciaux($idMission,$commerciaux); 
        PersonnelService::saveEquipeTemp($commerciaux,$coach,$idMission);

        if($success){
            $test = AccompagnementService::generatePlanning($idMission,$coach,$commerciaux);
        }
        $response = [
            'success' => $success,
            'test' => $test
        ];
        return $response;
        
    }

    public function getPlanning(Request $request){
        if(isset($request->idMission)){
            $idMission = $request->idMission;
            $coachs = Accompagnement::getCoachsFromMission($idMission);
            $accParJour = [];
            if(isset($coachs)){
                foreach($coachs as $coach){
                    $acc = Accompagnement::getFromMissionAndCoach($idMission,$coach->Coach);
                    $accParJour[] = [
                        "coach"=>$coach,
                        "accompagnement"=>AccompagnementService::toFormatParJour($acc),
                        "Commerciaux"=>Accompagnement::getCommerciaux($idMission,$coach->Coach)
                    ];
                }
            }
            $response = [
                'success' => true,
                'plannings' => $accParJour,
            ];
            return $response;
        }
    }

}
