<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Helpers\ControllerHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduitController extends Controller
{
    public function index(Request $request)
    {
        try{
            $produits = Produit::getAllLimited(ControllerHelper::getConditions($request));
            $response = 
            [
                'success'=> true,
                'message'=> count($produits).' results founds',
                'missions'=> $produits,
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

    public function getProduitByDesignation(Request $request)
    {
        try{
            $conditions = ControllerHelper::getConditions($request);
            if(isset($request->Designation)){
                $conditions[] = ['Designation','like',$request->Designation.'%'];
            }
            $produits = Produit::getAllDesignationLimited($conditions);
            $response = 
            [
                'success'=> true,
                'message'=> ' results founds'.$request->Designation,
                'produits'=> $produits,
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

    public function getFirst(Request $request){
        try{
            $produit = Produit::getFirstWhere(ControllerHelper::getConditions($request));
            $response = 
            [
                'success'=> true,
                'message'=> 'resultat trouvé',
                'produit'=> $produit,
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
