<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Fonction;
use Illuminate\Http\Request;
use App\Helpers\ControllerHelper;

class FonctionController extends Controller
{
    const DEFAULT_MAX_RESULT = 20;
    const AUTHORISED_ID = [2];
    const CUSTOM_FONCTION = [
        array("id" => "c1","designation" => "Commerciaux","customId"=>[1,6])
    ];

    public function index(Request $request){
        try{
            $fonctions = Fonction::getAllauthorisedId(ControllerHelper::getConditions($request));
            $response = 
            [
                'success'=> true,
                'message'=> count($fonctions).' results founds',
                'fonctions'=> $fonctions,
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
