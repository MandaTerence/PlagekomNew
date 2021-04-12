<?php

namespace App\Interfaces;

interface CustomAuthService {
    public function checkUtilisateur(string $matricule,string $password);
}
