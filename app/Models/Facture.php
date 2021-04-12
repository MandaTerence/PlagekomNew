<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;
    protected $table = 'facture';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Date',
        'Heure',
        'Id_facture',
        'Code_client',
        'Matricule_personnel',
        'Matricule_accomp',
        'Id_de_la_mission',
        'Id_zone',
        'Type',
        'Ville',
        'Quartier',
        'Lieu',
        'Level',
        'Statut',
        'contacts',		 			 
    ];

}
