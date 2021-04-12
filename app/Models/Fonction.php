<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fonction extends Model
{
    const AUTHORISED_ID = [2];
    const CUSTOM_FONCTION = [
        array("id" => "c1","designation" => "Commerciaux","customId"=>[1,6])
    ];

    use HasFactory;     
    protected $table = 'fonction';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = ['designation'];

    public static function getAllauthorisedId($conditions){
        $res = [];
        $fonctions = self::where($conditions)->get();
        foreach($fonctions as $f){
            foreach(self::AUTHORISED_ID as $id){
                if($f->id==$id){
                    $res[] = $f;
                }
            }
        }
        foreach (self::CUSTOM_FONCTION as $customFonction) {
            $res[] = (object)$customFonction;
        }
        return $res; 
    }
}