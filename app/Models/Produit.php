<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    
    use HasFactory;

    const DEFAULT_MAX_RESULT=10;

    protected $table = 'produit';
    protected $primaryKey = 'Code_produit';
    protected $keyType = 'string';

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Code_produit',  
        'Designation',     
        'ingredient',     
        'modedutilisation',  
        'argumentaire',
        'presentation',
        'Quantites',
        'Description', 
        'Detail_du_produit', 
        'Categorie', 
        'categorie_m', 
        'marque', 
        'fabricant',  
        'link',  
        'type',  
        'date_active',   
        'date_desactive',      
        'statut'
    ];

    public static function getAll($conditions=[]){
        return self::where($conditions)
        ->get();
    }

    public static function getAllLimited($conditions=[],$nbrResult=self::DEFAULT_MAX_RESULT){
        return self::where($conditions)
        ->take($nbrResult)
        ->get();
    }

    public static function getAllDesignationLimited($conditions=[],$nbrResult=self::DEFAULT_MAX_RESULT){
        return self::select('produit.Designation')
        ->where($conditions)
        ->take($nbrResult)
        ->get();
    }

    public static function getFirstWhere($conditions=[]){
        return self::join('prix', 'prix.Code_produit', '=', 'produit.Code_produit')
        ->select('produit.Designation','produit.Code_produit','prix.Prix_detail as prix')
        ->where($conditions)
        ->first();
    }
}
