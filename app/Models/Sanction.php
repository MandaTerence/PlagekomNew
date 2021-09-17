<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sanction extends Model
{
    use HasFactory;
    protected $table = 'sanction';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'code_sanction',
        'titre',
        'valeur',
        'unite'
    ];

}
