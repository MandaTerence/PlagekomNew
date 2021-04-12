<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EquipeService;
use App\Models\Accompagnement;

class EquipeController extends Controller
{
    public function create(Request $request,EquipeService $equipeService){
        $matriculesCommerciaux = $request->matriculesCommerciaux;
        $matriculeCoatch = $request->coatch;
        $IdMission = $request->IdMission;
        if($equipeService->checkIfValide($matriculesCommerciaux,$matriculeCoatch)){
            Accompagnement::createEquipe($matriculeCoatch,$matriculesCommerciaux,$IdMission);
        }   
    }
}
