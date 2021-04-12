<?php

namespace App\Services;

use App\Interfaces\CustomAuthService;
use App\Models\Utilisateur;
use Illuminate\Support\Str;

class AuthentificationService implements CustomAuthService{


    protected const COLUMN_NAME_ID = 'Matricule';
    protected const COLUMN_NAME_PASSWORD = 'Mode_de_pass_login';
    /// TO-DO change AUTHORISED_ID_PREFIX
    protected const AUTHORISED_ID_PREFIX = ['OTO','test'];

    public function __construct()
    {
        //
    }

    public function checkUtilisateur(string $matricule,string $password){
        if(($matricule!=null)&&($matricule!="")&&($password!=null)&&($password!="")){
            $authorised = false;
            $Utilisateur = Utilisateur::where('Matricule', $matricule)->where('Mode_de_pass_login',$password)->first();
            if(($Utilisateur!=null)&&($Utilisateur->Fonction_actuelle == 12)){
                $authorised = true;
            }
            if($authorised){
                return $Utilisateur;
            }
        }
    }
}