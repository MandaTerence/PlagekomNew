<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mission extends Model
{

    const DEFAULT_MAX_RESULT = 10;

    const DAY_INTERVAL = 30;

    use HasFactory;
    protected $table = 'mission';
    protected $primaryKey = 'Id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Id_de_la_mission',          
        'Designation',                
        'Type_de_mission',              
        'Date_de_fin',          
        'Date_depart',                
        'Statut',
        'Id_type',
    ];

    public function selectPersonnelFromMission(){
        return DB::table("detailmission")
        ->select("personnel")
        ->where("Id_de_la_mission",$this->Id_de_la_mission);
    }

    public static function getMissionTypeBetween($typeMission,$interval=""){
        if($interval==""){
            $nbrJour=self::DAY_INTERVAL;
            $interval = getDateInterval($nbrJour);
        }
        return self::whereRaw("
            (
                Date_depart >= '".$interval->firstDate."' AND
                Date_depart <= '".$interval->lastDate."' AND
                Id_type = ".$typeMission."
            )
            OR(
                Date_de_fin >= '".$interval->firstDate."' AND
                Date_de_fin <= '".$interval->lastDate."' AND
                Id_type = ".$typeMission."
            )
        ")
        ->get();
    }

    public static function getAllTypes(){
        return DB::table("type_mission")
        ->orderBy("designation","ASC")
        ->get();
    }

    public static function getAllId($conditions=[],$resultNumber=self::DEFAULT_MAX_RESULT){
        return self::select('Id_de_la_mission')
        ->where($conditions)
        ->take($resultNumber)
        ->get();
    }

    public static function getFirst($conditions=[]){
        return self::where($conditions)
        ->first();
    }

    public static function getTaux($idMission){
        $type=self::selectRaw("Type_de_mission as type")
        ->where("Id_de_la_mission",$idMission)
        ->first()->type;
        $montant = 0;
        if($type=="PROVINCE"){
            $montant = DB::table("malus_detail")
            ->whereRaw("Id_malus = 3")
            ->orderBy("montant_vente","ASC")
            ->first()->montant_vente;
        }
        else if($type=="MISSION"){
            $montant = DB::table("malus_detail")
            ->whereRaw("Id_malus = 1")
            ->orderBy("montant_vente","ASC")
            ->first()->montant_vente;
        }
        else{
            $montant = DB::table("malus_detail")
            ->whereRaw("Id_malus = 2")
            ->orderBy("montant_vente","ASC")
            ->first()->montant_vente;
        }
        return $montant;
    }
    
}
