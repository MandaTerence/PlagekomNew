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
        $code=$request->codeSanction;
        $res = SanctionService::getSanctionFromCode($code);
        $response = [
            'success' => true,
            'sanctions' => $res,
        ];
        return $response;
    }

}
