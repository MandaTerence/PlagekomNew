<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sanction extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'malus_detail';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Date_d_embauche',			 			 	
        'Id Primaire',
        'Id_malus Index',
        'montant_vente',
        'valeur_malus',
    ];

}
