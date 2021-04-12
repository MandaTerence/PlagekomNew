<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Controle extends Model
{
    const DEFAULT_MAX_RESULT = 10;
    
    use HasFactory;
    protected $table = 'controle';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'sim',
        'debut',
        'fin',
        'commercial',
        'controlleur'
    ];
}
