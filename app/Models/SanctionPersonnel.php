<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanctionPersonnel extends Model
{
    use HasFactory;

    protected $table = 'sanction_personnel';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'code_sanction',
        'matricule_personnel',
        'matricule_coach',
        'matricule_controlleur',
        'date',
        'id_sanction',
        'type_personnel',
    ];
}
