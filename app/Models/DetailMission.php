<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Personnel;

class DetailMission extends Model
{
    use HasFactory;
    protected $table = 'detailmission';
    protected $primaryKey = 'Id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Id_de_la_mission',  
        'personnel',
        'Equipe',
        'Date_d_activation', 
        'Date_desactive',
        'Statut_du_personnel',
    ];

    public static function getPersonnelFromCoach($coach = null,$idMission = null){
        if(($coach!=null)&&($idMission!=null)){
            $personnels = [];
            $matriculesPersonnels = self::select('personnel')
            ->where([['Equipe','like','%'.$coach.'%'],['Id_de_la_mission','like',$idMission]])
            ->get();
            foreach($matriculesPersonnels as $matricule){
                $condition = [['Matricule','like',$matricule->personnel]];
                $personnels[] = Personnel::getFirstWithCA($condition);
            }
            return $personnels;
        }
        else{
            return [];
        }
    }
}
