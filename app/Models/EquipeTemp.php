<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipeTemp extends Model
{
    use HasFactory;
    protected $table = 'equipe_temporaire';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Id_de_la_mission',
        'matricule_personnel',
        'type'
    ];

    protected $guarded = [];
}
