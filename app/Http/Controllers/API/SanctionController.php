<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sanction;
use Illuminate\Http\Request;
use App\Services\SanctionService;

class SanctionController extends Controller
{
    public function create(Request $request){
    }

    public function getAll(Request $request){
        $res = SanctionService::getAll();
        $response = [
            'success' => true,
            'mallus' => $res,
        ];
        return $response;
    }

}
