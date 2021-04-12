<?php

namespace App\Services;

use App\Models\Utilisateur;
use Illuminate\Support\Str;

class EquipeService {

    const MIN_COMMERCIAUX = 7;
    const MAX_COMMERCIAUX = 8;

    public function __construct()
    {
        //
    }

    public function checkIfValide($matriculesCommerciaux=null,$matriculeCoatch=null){
        if(($matriculesCommerciaux == null)||($matriculeCoatch == null)){
            return false;
        }
        else if((count($matriculesCommerciaux)<self::MIN_COMMERCIAUX)||(count($matriculesCommerciaux)>self::MAX_COMMERCIAUX)){
            return false;
        }
        else {
            return true;
        }
    }

}