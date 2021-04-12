<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Controle;
use Illuminate\Http\Request;

class ControleController extends Controller
{
    public function create(Request $request){
        $controle = new Controle();
        $controle->sim = $request->input('sim');
        $controle->debut = $request->input('debut');
        $controle->fin = $request->input('fin');
        $controle->commercial = $request->input('commercial');
        $controle->controlleur = $request->input('controlleur');
        $controle->save();
        $response = [
            'success' => true
        ];
        return $response;
    }

}
