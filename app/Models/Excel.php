<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Accompagnement;
use App\Models\Personnel;
use App\Models\Mission;
use App\Models\DetailMission;
use App\Helpers\ControllerHelper;
use Illuminate\Support\Facades\DB;
use App\Services\ClassementService;
use App\Services\PersonnelService;
use App\Services\AccompagnementService;

class Excel extends Model
{
    const DEFAULT_MAX_RESULT = 10;

    const DEFAULT_COEF = [
        'global' => 5,
        'local' => 2,
        'mission' => 1,
        'produitPlusCher' => 1,
        'produitMoinsCher' => 1,
        'produit' => []
    ];
    const DATE_JOUR = [
        'Dimanche',
        'Lundi',
        'Mardi',
        'Mercredi',
        'Jeudi',
        'Vendredi',
        'Samedi',
    ];

    public static function check($lien)
    {
        $lien = substr($lien, 5);
        $data = json_decode($lien);
        
        if($data->excel=="evaluation"){
            self::getEvaluation($data);
        }
        else if($data->excel=="Planning"){
            self::getPlanning($data);
        }
        else if($data->excel=="controlMission"){
            self::getControlMission($data);
        }

/*
        $excel = "";
        $excel .=  "Code client\tNum Commande\tClient\tDate de Commande\tDate de Livraison\tLien Facebook\tContact\tProduit\tPU\tQTT\tlieu de livraison\tOPL\tQuartier\tVille\tMontant\tLocalisation\tFrais\tRemarque\tStatut\n";

        header("Content-type: application/vnd.ms-excel");
        header("Content-disposition: attachment; filename=evaluation.xls");

        print $excel;
        exit;
*/
    }


    /*
    {"idMission":"ROAD_SHOW_FAMILY_2021_05_10","Commerciaux":[{"Matricule":"VP21217","sanctions":[],"controles":[],"Nom":"RAHERIMALALASOA","Prenom":"Sabrinah"},{"Matricule":"VP21209","sanctions":[],"controles":[],"Nom":"RAZAIARISOLO","Prenom":"Andoniaina Jisl\u00e8ne"},{"Matricule":"VP21200","sanctions":[],"controles":[],"Nom":"RASOANIRINA","Prenom":"Harilalaina Christelle"},{"Matricule":"VP12087","sanctions":[],"controles":[],"Nom":"FARAMALALA","Prenom":"HAINGOTIANA"},{"Matricule":"VP21220","sanctions":[],"controles":[],"Nom":"RAKOTOMANANA NIRINA","Prenom":"Daniel"},{"Matricule":"VP21216","sanctions":[],"controles":[],"Nom":"RATONGAVELO","Prenom":"Notiavina Laurah"},{"Matricule":"VP20001","sanctions":[],"controles":[],"Nom":"RAHARINIRIANA","Prenom":"Hobisoa Tahiana"},{"Matricule":"VP21206","sanctions":[],"controles":[],"Nom":"RAKOTONDRAZANANY","Prenom":"Maminirina Mampionona"},{"Matricule":"VP21171","sanctions":[],"controles":[],"Nom":"RAFETIARISOA","Prenom":"Hariniaina Claudia"},{"Matricule":"VP21183","sanctions":[],"controles":[],"Nom":"RAHARINIRINA ","Prenom":"Christine"},{"Matricule":"VP20121","sanctions":[],"controles":[],"Nom":"RAZAIHELIMANANA","Prenom":"Fananiaina Fanja"}],"Coach":[{"Matricule":"COTN102","sanctions":[],"controles":[],"Nom":"RAKOTONIAINA ","Prenom":"Harivelo Zo Patrick"},{"Matricule":"COTN128","sanctions":[],"controles":[],"Nom":"RAZAINDRAZAKA","Prenom":"NJAKATINA RINAH"},{"Matricule":"COTN127","sanctions":[],"controles":[],"Nom":"RAMANANTENASOA","Prenom":"Ny Ambina Lalaina"},{"Matricule":"COTN131","sanctions":[],"controles":[],"Nom":"RAKOTONIRINA","Prenom":"MAMINIAINA"}],"jour":"2021-05-10","ville":"ANTANANARIVO"} */
/*
    {"idMission":"ROAD_SHOW_2021_07_01","Commerciaux":[{"Matricule":"VP21300 ","sanctions":[{"code_sanction":"C-ABS-01-TER","titre":"ABSENCE DU COACH AVEC LE GROUPE SUR LE TERRAINABSE","valeur":2500,"unite":"APP\/HR"},{"code_sanction":"C-APM-11-MIS","titre":"ABSENCE APRES-MISSION - COACH","valeur":10000,"unite":"JOUR"}],"controles":[{"sim":"Telma","debut":"2021-07-01 15:35:35","fin":"2021-07-01 16:35:35","duree":"01:00:00"}],"Nom":"RAFARASOAVONJENA","Prenom":"Zanamino Lina"},{"Matricule":"VP21321 ","sanctions":[],"controles":[],"Nom":"RANDRIAMIRADO","Prenom":"Toky Nandrianina"},{"Matricule":"VP21326 ","sanctions":[],"controles":[],"Nom":"RANDRIAMIHAINGO","Prenom":"V\u00e9ronique"}],"Coach":[{"Matricule":"COTN134","sanctions":[],"controles":[],"Nom":"RANDRIAMIZAHA","Prenom":"Njaraniaina"},{"Matricule":"COTN137","sanctions":[],"controles":[],"Nom":"HEVIDRAZANA","Prenom":"Natoto Rhandy"},{"Matricule":"COTN128","sanctions":[],"controles":[],"Nom":"RAZAINDRAZAKA","Prenom":"NJAKATINA RINAH"},{"Matricule":"COTN127","sanctions":[],"controles":[],"Nom":"RAMANANTENASOA","Prenom":"Ny Ambina Lalaina"}],"jour":"2021-07-01","ville":"ANTANANARIVO"}
*/
    public static function getControlMission($data){
        $missions = PersonnelService::getAllFromMission($data->jour);
        //return $missions;
        $excel = "";
        foreach($missions as $mission){
            if($mission["idMission"] == $data->idMission){
                $excel .="\n";
                $excel .= "\t\t Mission: \t ".$data->idMission."\n\n";
                $excel .= "nbr de commerciaux\t".count($mission["Commerciaux"])."\tVille d animation\t".$mission["ville"]."\n\n";
                $excel .= "Matricule\tHeure de controle\tVille d animation\tcode de sanction\tEtat Controle\tMontant sanction\n";

                $excel .= "\nCommerciaux\n";

                foreach($mission["Commerciaux"] as $commerciaux){
                    $excel .= $commerciaux["Matricule"]."\t";
                    if(count($commerciaux["controles"])>0){
                        foreach($commerciaux["controles"] as $controle){
                            $excel .= $controle["debut"]." a ".$controle["fin"].",";
                        }
                    }
                    else{
                        $excel .= "aucun";
                    }
                    $excel .="\t";
                    $excel .=$mission["ville"]."\t";
                    $totalSanction = 0;
                    if(count($commerciaux["sanctions"])>0){
                        foreach($commerciaux["sanctions"] as $sanction){
                            $excel .= $sanction["code_sanction"].",";
                            $totalSanction += (int)$sanction["valeur"];
                        }
                    }
                    else{
                        $excel .= "aucun";
                    }
                    $excel .= "\t";
                    if(count($commerciaux["controles"])>0){
                        $excel .= "effectue\t";
                    }else{
                        $excel .= "non effectue\t";
                    }
                    $excel .= $totalSanction."\t";
                    $excel .= "\n";
                }

                $excel .= "\nCoachs\n";

                foreach($mission["Coach"] as $commerciaux){
                    $excel .= $commerciaux["Matricule"]."\t";
                    if(count($commerciaux["controles"])>0){
                        foreach($commerciaux["controles"] as $controle){
                            $excel .= $controle["debut"]." a ".$controle["fin"].",";
                        }
                    }
                    else{
                        $excel .= "aucun";
                    }
                    $excel .="\t";
                    $excel .=$mission["ville"]."\t";
                    $totalSanction = 0;
                    if(count($commerciaux["sanctions"])>0){
                        foreach($commerciaux["sanctions"] as $sanction){
                            $excel .= $sanction["code_sanction"].",";
                            $totalSanction += (int)$sanction["valeur"];
                        }
                    }
                    else{
                        $excel .= "aucun";
                    }
                    $excel .= "\t";
                    if(count($commerciaux["controles"])>0){
                        $excel .= "effectue\t";
                    }else{
                        $excel .= "non effectue\t";
                    }
                    $excel .= $totalSanction."\t";
                    $excel .= "\n";
                }

            }
        }
        header("Content-disposition: attachment; filename=control.xls");
        print $excel;
    }

    public static function getPlanning($data){
        $idMission = $data->idMission;
        $coachs = Accompagnement::getCoachsFromMission($idMission);
        $accParJour = [];
        $mission = Mission::getFirst([["Id_de_la_mission",$idMission]]);
        $depart = $mission->Date_depart;
        $fin = $mission->Date_de_fin;
        if(isset($coachs)){
            foreach($coachs as $coach){
                $acc = Accompagnement::getFromMissionAndCoach($idMission,$coach->Coach);
                $acc = AccompagnementService::toFormatParJour($acc);
                $acc = AccompagnementService::completeSunday($acc);
                $accParJour[] = [
                    "coach"=>$coach,
                    "accompagnement"=>$acc
                ];
            }
        }
        $excel = "\t\t PLANNING D'ACCOMPAGNEMENT ".$idMission."\n\n";
        $excel .= "ACCOMPAGNEMENT - MATIN\t\tHeure de debut\t08:30:00\t10:30:00\t08:30:00\t10:30:00\n";
        $excel .= "\t\tHeure de fin\t10:00:00\t12:00:00\t10:00:00\t12:00:00\n";
        $excel .= "ACCOMPAGNEMENT - APRES MIDI\t\tHeure de debut\t14:30:00\t16:30:00\t14:30:00\t16:30:00\n";
        $excel .= "\t\tHeure de fin\t16:00:00\t18:00:00\t16:00:00\t18:00:00\n\n";
        $excel .= "DATE DE LA MISSION\t\tDate de depart\t".$depart."\t".$depart."\t".$depart."\t".$depart."\n";
        $excel .= "\t\tDate de fin\t".$fin."\t".$fin."\t".$fin."\t".$fin."\n\n";

        foreach($accParJour as $acc){
            $excel .= "Coach\t\t".$acc["coach"]->Coach."\t\t\t\t\n";
            foreach($acc["accompagnement"] as $plan){
                $d = date('w', strtotime($plan["jour"]));
                $date = self::getDate($d);
                $mat1 = $plan["matin"][0]["Commercial"];
                $mat2 = $plan["matin"][1]["Commercial"];
                $ap1 = $plan["apresMidi"][0]["Commercial"];
                $ap2 = $plan["apresMidi"][1]["Commercial"];
                $excel .= $date."\t".$plan["jour"]."\t".$idMission."\t".$mat1."\t".$mat2."\t".$ap1."\t".$ap2."\n";
            }
        }

        header("Content-disposition: attachment; filename=plannings.xls");
        print $excel;
    }

    public static function getPlanningOld($data){
        $idMission = $data->idMission;
        $coachs = Accompagnement::getCoachsFromMission($idMission);
        $accParJour = [];
        $mission = Mission::getFirst([["Id_de_la_mission",$idMission]]);
        $depart = $mission->Date_depart;
        $fin = $mission->Date_de_fin;
        if(isset($coachs)){
            foreach($coachs as $coach){
                $acc = Accompagnement::getFromMissionAndCoach($idMission,$coach->Coach);
                $acc = AccompagnementService::toFormatParJour($acc);
                $acc = AccompagnementService::completeSunday($acc);
                $accParJour[] = [
                    "coach"=>$coach,
                    "accompagnement"=>$acc
                ];
            }
        }
        $excel = "\t\t PLANNING D'ACCOMPAGNEMENT ".$idMission."\n\n";
        $excel .= "ACCOMPAGNEMENT - MATIN\t\tHeure de debut\t08:30:00\t10:30:00\t08:30:00\t10:30:00\n";
        $excel .= "\t\tHeure de fin\t10:00:00\t12:00:00\t10:00:00\t12:00:00\n";
        $excel .= "ACCOMPAGNEMENT - APRES MIDI\t\tHeure de debut\t14:30:00\t16:30:00\t14:30:00\t16:30:00\n";
        $excel .= "\t\tHeure de fin\t16:00:00\t18:00:00\t16:00:00\t18:00:00\n\n";
        $excel .= "DATE DE LA MISSION\t\tDate de depart\t".$depart."\t".$depart."\t".$depart."\t".$depart."\n";
        $excel .= "\t\tDate de fin\t".$fin."\t".$fin."\t".$fin."\t".$fin."\n\n";
        $excelRow = [
            "date" => "aucun",
            "row" => "Coach\t\t"
        ];

        foreach($accParJour as $acc){
            $excelRow[0]["row"] .=$acc["coach"]->Coach."\t\t\t\t";
        }
        $excelRow[0]["row"] .="\n";

        foreach($accParJour[0]["accompagnement"] as $acc){
            $excelRow[] = $plan["jour"];
            $d = date('w', strtotime($plan["jour"]));
            $date = self::getDate($d);
            $excelRow[] = [
                "date" => $plan["jour"],
                "row" =>$date."\t".$plan["jour"]."\t"
            ];
        }
        foreach($excelRow as $row){
            foreach($accParJour as $acc){
                foreach($acc["accompagnement"] as $plan){
                    if($plan["jour"]==$row["date"]){

                        $d = date('w', strtotime($plan["jour"]));
                        $date = self::getDate($d);
                        $mat1 = $plan["matin"][0]["Commercial"];
                        $mat2 = $plan["matin"][1]["Commercial"];
                        $ap1 = $plan["apresMidi"][0]["Commercial"];
                        $ap2 = $plan["apresMidi"][1]["Commercial"];

                        $row["row"] .="\t".$idMission."\t".$mat1."\t".$mat2."\t".$ap1."\t".$ap2."\n";

                        break;
                    }
                }
            }
        }
        foreach($accParJour as $acc){
            $excel .= "Coach\t\t".$acc["coach"]->Coach."\t\t\t\t\n";
            foreach($acc["accompagnement"] as $plan){
                $d = date('w', strtotime($plan["jour"]));
                $date = self::getDate($d);
                $mat1 = $plan["matin"][0]["Commercial"];
                $mat2 = $plan["matin"][1]["Commercial"];
                $ap1 = $plan["apresMidi"][0]["Commercial"];
                $ap2 = $plan["apresMidi"][1]["Commercial"];
                $excel .= $date."\t".$plan["jour"]."\t".$idMission."\t".$mat1."\t".$mat2."\t".$ap1."\t".$ap2."\n";
            }
        }
        header("Content-disposition: attachment; filename=plannings.xls");
        print $excel;
    }

    public static function getDate($d){
        return self::DATE_JOUR[$d];
    }

    public static function getEvaluation($data){
        $equipeA = [];
        $excel = $data->excel;
        $Matricules= $data->Matricules;
        $Produits= $data->Produits;
        
        $dateDebut= $data->dateDebut;
        $dateFin= $data->dateFin;

        $listeDateExclu= $data->listeDateExclu;

        $pourcentage= $data->pourcentage;
        $minimumVente= $data->minimumVente;

        $interval = getDateInterval(30);

        $equipeA = PersonnelService::getPersonnelFromMatricule($Matricules);

        if((isset($dateDebut))&&(isset($dateFin))){
            $interval = (object) [
                "lastDate" => $dateFin,
                "firstDate" => $dateDebut
            ];
        }

        $jourDeTravail = PersonnelService::getJourTravail($interval,$listeDateExclu);
        $equipe = [];

        foreach($equipeA as $personnel){
            $personnel->getAllCA($interval,$listeDateExclu);
            $personnel->getNbrJourObjectifAtteint($interval,$listeDateExclu);
            $personnel->getPourcentageObjectif($jourDeTravail);
            $personnel->getNbrProduit($interval);
            $personnel->getStatutbimestriel();
            $personnel->getAssuidite();
            $personnel->getCAMoyen();
        }
        
        $classement = ClassementService::getEvaluation($equipeA,self::DEFAULT_COEF,$interval,$minimumVente,$listeDateExclu,$pourcentage);
        $excel = "\tPlace\tMatricule\tNom et Prenom\tCA Mission\tCA Local\tCA Total\tCA Moyen\tratio de vente\tassuidite\tstatut\n";
        foreach($classement as $personnel){

            $personnel->CAMoyen = (int)$personnel->CAMoyen;

            $excel .= "\t$personnel->place\t$personnel->Matricule\t$personnel->Nom $personnel->Prenom\t$personnel->CAMission\t$personnel->CALocal\t$personnel->CAGlobal\t$personnel->CAMoyen\t".number_format($personnel->pourcentageObjectif, 2, '.', '')."\t".number_format($personnel->assuidite, 2, '.', '')."\t$personnel->etatVente\n";
        }
        //header("Content-type: application/vnd.ms-excel");
        header("Content-disposition: attachment; filename=evaluation.xls");
        print $excel;
    }
}
