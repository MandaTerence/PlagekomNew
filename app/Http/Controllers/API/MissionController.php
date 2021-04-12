<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helpers\ControllerHelper;
use Illuminate\Http\Request;
use App\Models\Mission;

class MissionController extends Controller
{
    public function index(Request $request){
        try{
            $missions = Mission::getAllId(ControllerHelper::getConditions($request));
            $response = 
            [
                'success'=> true,
                'message'=> count($missions).' results founds',
                'missions'=> $missions,
            ];
            return $response;
        } 
        catch (\Illuminate\Database\QueryException $exception) {
            $response = 
            [
                'success'=> false,
                'message'=> $exception->errorInfo
            ];
            return $response;
        }
    }
}
