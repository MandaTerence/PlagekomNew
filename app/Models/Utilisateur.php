<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'personnel';
    protected $primaryKey = 'Matricule';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        //'Matricule',
        'Date_d_embauche',			 			 	
        'Nom',	   		 			   	
        'Prenom',	   		 			   	
        'Date_de_naissance', 			 			   	
        'Lieu_de_naissance', 	   		 			   	
        'Sexe', 	   		 			   	
        'Situation_Matrimoniale', 	   		 			   	
        'Nombre_d_enfant', 			   	
        'Cin_personnel', 	   		 			   	
        'Date_cin_personnel',		 			     
        'Lieu_delivrance_du_cin_personnel', 	   		 			   
        'Date_duplicata_cin_personnel',		
        'Lieu_de_dupliacata_cin_personnel',   				   	
        'Adresse_du_personnel', 			   	
        'Contact_du_personnel',	   		 			   	
        'Nom_et_prenom_du_tuteur',  		 			   	
        'Lien_de_parente',	 			   	
        'Cin_du_tuteur',		   	
        'Date_de_delivrance_cin_tuteur',		 			   	
        'Adresse_du_tuteur',		 			   	
        'Contact_du_tuteur',		 			   	
        'Fonction_a_l_embauche',	 			   	
        'Fonction_actuelle',			   	
        'Mode_de_pass_login',		 			   	
        'statut',
    ];
}
