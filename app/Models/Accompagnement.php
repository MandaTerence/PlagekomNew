<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EquipeCoach;

class Accompagnement extends Model
{
    use HasFactory;
    protected $table = 'mesaccompanement';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;

    const DEFAULT_MAX_RESULT = 10;

    protected $fillable = [
        'Id_de_la_mission',
        'Commercial',
        'Coach',
        'Date',
    	'Heure_debut',
        'Heure_fin',
        'Ordre',
    ];

    public static function getFromMission($mission){
        if(isset($mission)){
            return self::where('Id_de_la_mission','like',$mission)
            ->get();
        }
    }

    public static function getCommerciaux($mission,$coach){
        if((isset($mission))&&(isset($coach))){
            return self::select('Commercial')
            ->where('Id_de_la_mission',$mission)
            ->where('Coach',$coach)
            ->groupBy('Commercial','Coach')
            ->get()
            ;
        }
        else{
            return false;
        }
    }

    public static function getFromMissionAndCoach($mission,$coach='all',$nbrRes=self::DEFAULT_MAX_RESULT){
        if((isset($mission))&&(isset($coach))){
            if($coach=='all'){
                return self::where('Id_de_la_mission','like',$mission)
                ->get()
                ;
            }
            else{
                return self::where('Id_de_la_mission','like',$mission)
                ->where('Coach','like',$coach)
                ->get()
                ;
            }
        }
        else{
            return false;
        }
    }
    
    public static function getCoachsFromMission($mission){
        if(isset($mission)){
            return self::select('Coach')
            ->distinct()
            ->where('Id_de_la_mission','like',$mission)
            ->take(2)
            ->get()
            ;
        }
    }

    public static function getCoachsFromMissionSQL($mission){
        if(isset($mission)){
            return self::select('Coach')
            ->distinct()
            ->where('Id_de_la_mission','like',$mission)
            ->take(2)
            ->toSql()
            ;
        }
    }
}
