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
            $toutesSan = SanctionPersonnel::selectRaw("sanction_personnel.id as id,sanction_personnel.date as datetime,DATE(sanction_personnel.date) as date,TIME(sanction_personnel.date) as time,sanction.code_sanction as code_sanction,sanction.titre as titre,sanction.valeur as valeurs")
            ->where('matricule_personnel',$request->matricule)
            ->join('sanction', 'sanction.id', '=', 'sanction_personnel.id_sanction')
            ->get();
            $sanctionPersonnels = SanctionPersonnel::selectRaw("sanction_personnel.id as id,sanction_personnel.date as datetime,DATE(sanction_personnel.date) as date,TIME(sanction_personnel.date) as time,sanction.code_sanction as code_sanction,sanction.titre as titre,sanction.valeur as valeur")
            ->where('matricule_personnel',$request->matricule)
            ->whereRaw('MONTH(date)=MONTH(NOW())')
            ->whereRaw('YEAR(date)=YEAR(NOW())')
            ->join('sanction', 'sanction.id', '=', 'sanction_personnel.id_sanction')
            ->get();
            return [
                "success" => true,
                "sanctionPersonnels" => $sanctionPersonnels,
                "toutesSan" => $toutesSan
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
