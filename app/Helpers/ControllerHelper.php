<?php
namespace App\Helpers;

use Illuminate\Http\Request;

Class ControllerHelper{
    static function getConditions(Request $request){
        $conditions = [];
        if(isset($request->criteres)){
            $crit = json_decode($request->criteres);
            foreach($crit as $column => $value){
                $conditions[] = [$column,'like',$value];
            }
        }
        return $conditions;
    }
}