<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Excel extends Model
{
    public static function check($lien)
    {
        $type = $lien;
        $excel = "";
        $excel .=  "Code client\tNum Commande\tClient\tDate de Commande\tDate de Livraison\tLien Facebook\tContact\tProduit\tPU\tQTT\tlieu de livraison\tOPL\tQuartier\tVille\tMontant\tLocalisation\tFrais\tRemarque\tStatut\n";

        header("Content-type: application/vnd.ms-excel");
        header("Content-disposition: attachment; filename=vente_".$type."_du_".date('d-m-Y').".xls");

        print $excel;
        exit;
    }
}
