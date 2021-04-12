<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipeCoach extends Model
{
    use HasFactory;
    protected $table = 'equipe_coach';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Coach',
        'Commercial',
        'Date',
    ];

    protected $guarded = [];

}
