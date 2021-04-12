<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{

    const DEFAULT_MAX_RESULT = 10;

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
    ];

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
    
}
