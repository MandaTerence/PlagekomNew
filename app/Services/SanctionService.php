<?php

namespace App\Services;

use App\Models\Sanction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SanctionService {

    public static function getAll(){
        
    }

    public static function getSanctionFromCode($code="%"){
        return Sanction::whereRaw("code_sanction like '".$code."%'")
        ->get();
    }

}