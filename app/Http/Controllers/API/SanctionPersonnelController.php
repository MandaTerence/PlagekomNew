<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SanctionPersonnel;
use Illuminate\Http\Request;
use App\Services\SanctionService;

class SanctionPersonnelController extends Controller
{
    public function create(Request $request){
        $sanctionPersonnel = new SanctionPersonnel();
        $sanctionPersonnel->code_sanction = $request->input('code_sanction');
        $sanctionPersonnel->matricule_personnel = $request->input('matricule_personnel');
        $sanctionPersonnel->matricule_coach = $request->input('matricule_coach');
        $sanctionPersonnel->matricule_controlleur = $request->input('matricule_controlleur');
        $sanctionPersonnel->id_sanction = $request->input('id_sanction');
        $sanctionPersonnel->type_personnel = $request->input('type_personnel');
        $sanctionPersonnel->save();
        $response = [
            'success' => true
        ];
        return $response;
    }

    public function getFromMatricule(Request $request){
        if(isset($request->matricule)){
            $res =SanctionPersonnel::select("sanction_personnel.id","sanction.code_sanction","sanction.titre")
            ->where('matricule_personnel',$request->matricule)
            ->join('sanction', 'sanction.id', '=', 'sanction_personnel.id_sanction')
            ->get();
            return [
                "success" => true,
                "sanctionPersonnels" => $res,
            ];
        }
    }

    public function delete(Request $request){
        if(isset($request->id)){
            SanctionPersonnel::destroy($request->id);
            return [
                "success" => true,
            ];
        }
        return [
            "success" => false,
        ];
    }

}
