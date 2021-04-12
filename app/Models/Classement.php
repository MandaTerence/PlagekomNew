<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Classement extends Model
{
    const DEFAULT_MAX_RESULT = 10;
    
    use HasFactory;
    protected $table = 'Classement';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'place',
        'Id_de_la_mission',
        'Commercial'
    ];

    public static function getFromMission($mission=null,$nbrOfResult=self::DEFAULT_MAX_RESULT){
        if($mission != null){
            return self::where('Id_de_la_mission','like',$mission)
            ->take($nbrOfResult)
            ->get();
        }
    }
    public static function saveFromCommerciaux($idMission,$commerciaux){
        try {
            foreach($commerciaux as $com){
                $classement = new Classement;
                $classement->place = $com['Place'];
                $classement->Id_de_la_mission = $idMission;
                $classement->Commercial = $com['Matricule'];
                $classement->save();
            }
            return true;
        }catch (\Exception $e) {
            return $e;
        }
    }
    public static function getFromMatricules($idMission,$personnels=null){
        $searchquery = '(';
        foreach($personnels as $personnel){
            $searchquery .="'".$personnel."',";
        }
        $searchquery = substr_replace($searchquery, ")", -1);
        return Classement::whereRaw("Commercial in ".$searchquery)
            ->whereRaw("Id_de_la_mission like '".$idMission."'")
            ->get();
    }
    public static function getFromMissionAndCoach($idMission,$coach){
        $searchquery = '(';
        foreach($personnels as $personnel){
            $searchquery .="'".$personnel."',";
        }
        $searchquery = substr_replace($searchquery, ")", -1);
        return Classement::whereRaw("Commercial in ".$searchquery)
        ->whereRaw("Id_de_la_mission like '".$idMission."'")
        ->get(); 
    }
}
