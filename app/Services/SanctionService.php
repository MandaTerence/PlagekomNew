<?php

namespace App\Services;

use App\Models\Malus;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SanctionService {

    public static function getAll(){
        $malus = [];
        $malusAbsence = DB::table("malus_absence")
        ->get();
        foreach($malusAbsence as $m){
            $malus[] = [
                'nom'=>'Malus Absence'.$m->Designation,
                'valeur'=>$m->Valeur
            ];
        }
        return $malus;
    }

}