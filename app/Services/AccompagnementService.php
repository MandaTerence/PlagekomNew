<?php

namespace App\Services;

use App\Models\DetailMission;
use App\Models\Classement;
use App\Models\Mission;
use App\Models\Accompagnement;


class AccompagnementService {

    CONST DATE_FORMAT = 'yy-m-d';

    CONST JOUR_ACCOMPAGNEMENT = [
        //lundi
        ['Date'=>1,'place'=>8,'Heure_debut'=>'08:00:00','Heure_fin'=>'10:00:00','Ordre'=>1],
        ['Date'=>1,'place'=>7,'Heure_debut'=>'10:30:00','Heure_fin'=>'12:00:00','Ordre'=>2],

        ['Date'=>1,'place'=>8,'Heure_debut'=>'14:00:00','Heure_fin'=>'15:30:00','Ordre'=>1],
        ['Date'=>1,'place'=>7,'Heure_debut'=>'16:00:00','Heure_fin'=>'17:30:00','Ordre'=>2],
        //mardi
        ['Date'=>2,'place'=>6,'Heure_debut'=>'08:00:00','Heure_fin'=>'10:00:00','Ordre'=>1],
        ['Date'=>2,'place'=>5,'Heure_debut'=>'10:30:00','Heure_fin'=>'12:00:00','Ordre'=>2],

        ['Date'=>2,'place'=>6,'Heure_debut'=>'14:00:00','Heure_fin'=>'15:30:00','Ordre'=>1],
        ['Date'=>2,'place'=>5,'Heure_debut'=>'16:00:00','Heure_fin'=>'17:30:00','Ordre'=>2],
        //mercredi
        ['Date'=>3,'place'=>4,'Heure_debut'=>'08:00:00','Heure_fin'=>'10:00:00','Ordre'=>1],
        ['Date'=>3,'place'=>3,'Heure_debut'=>'10:30:00','Heure_fin'=>'12:00:00','Ordre'=>2],

        ['Date'=>3,'place'=>4,'Heure_debut'=>'14:00:00','Heure_fin'=>'15:30:00','Ordre'=>1],
        ['Date'=>3,'place'=>3,'Heure_debut'=>'16:00:00','Heure_fin'=>'17:30:00','Ordre'=>2],
        //jeudi
        ['Date'=>4,'place'=>2,'Heure_debut'=>'08:00:00','Heure_fin'=>'10:00:00','Ordre'=>1],
        ['Date'=>4,'place'=>1,'Heure_debut'=>'10:30:00','Heure_fin'=>'12:00:00','Ordre'=>2],

        ['Date'=>4,'place'=>2,'Heure_debut'=>'14:00:00','Heure_fin'=>'15:30:00','Ordre'=>1],
        ['Date'=>4,'place'=>1,'Heure_debut'=>'16:00:00','Heure_fin'=>'17:30:00','Ordre'=>2],
        //vendredi
        ['Date'=>5,'place'=>8,'Heure_debut'=>'08:00:00','Heure_fin'=>'10:00:00','Ordre'=>1],
        ['Date'=>5,'place'=>7,'Heure_debut'=>'10:30:00','Heure_fin'=>'12:00:00','Ordre'=>2],

        ['Date'=>5,'place'=>8,'Heure_debut'=>'14:00:00','Heure_fin'=>'15:30:00','Ordre'=>1],
        ['Date'=>5,'place'=>7,'Heure_debut'=>'16:00:00','Heure_fin'=>'17:30:00','Ordre'=>2],
        //samedi
        ['Date'=>6,'place'=>6,'Heure_debut'=>'08:00:00','Heure_fin'=>'10:00:00','Ordre'=>1],
        ['Date'=>6,'place'=>5,'Heure_debut'=>'10:30:00','Heure_fin'=>'12:00:00','Ordre'=>2],

        ['Date'=>6,'place'=>4,'Heure_debut'=>'14:00:00','Heure_fin'=>'15:30:00','Ordre'=>1],
        ['Date'=>6,'place'=>3,'Heure_debut'=>'16:00:00','Heure_fin'=>'17:30:00','Ordre'=>2]
    ];

    public function __construct()
    {
        //
    }

    public static function test(){
        return "ok test";
    }

    public static function generatePlanningNew($idMission,$coach,$personnels=null){
        if($personnels==null){
            $personnels = DetailMission::getPersonnelFromCoach($coach,$idMission);
        }
        $matricules = [];
        foreach($personnels as $p){
            if(isset($p['Matricule'])){
                $matricules[] = $p['Matricule'];
            }
            else{
                $matricules[] = $p->Matricule;
            }
        }
        $classement = Classement::getFromMatricules($idMission,$matricules);
        $mission = Mission::getFirst([['Id_de_la_mission',$idMission]]);
        $Date_depart = $mission->Date_depart;
        $Date_de_fin = $mission->Date_de_fin;
        $periods = self::date_range($Date_depart,$Date_de_fin);
        $accArray = [];
        for($i=0;$i<count($periods);$i++){
            $p = str_replace('/', '-', $periods[$i]);
            $jour = date('w', strtotime($p));
            $dateInserer = date(self::DATE_FORMAT, strtotime($p));
            foreach(self::JOUR_ACCOMPAGNEMENT as $plan){
                if((($i%6)+1) == $plan['Date']){
                    $com = $classement[$plan['place']-1];
                    $acc = [
                        'Id_de_la_mission'=>$idMission,
                        'Commercial'=>$com->Commercial,
                        'Coach'=>$coach,
                        'Date'=>$dateInserer,
                        'Heure_debut'=>$plan['Heure_debut'],
                        'Heure_fin'=>$plan['Heure_fin'],
                        'Ordre'=>$plan['Ordre']
                    ];
                    $accArray[] = $acc;
                }
            }
        }
        Accompagnement::insert($accArray);
        return true;
    }

    public static function generatePlanning($idMission,$coach,$personnels=null){
        if($personnels==null){
            $personnels = DetailMission::getPersonnelFromCoach($coach,$idMission);
        }
        $matricules = [];
        foreach($personnels as $p){
            if(isset($p['Matricule'])){
                $matricules[] = $p['Matricule'];
            }
            else{
                $matricules[] = $p->Matricule;
            }
        }
        $classement = Classement::getFromMatricules($idMission,$matricules);
        $mission = Mission::getFirst([['Id_de_la_mission',$idMission]]);
        $Date_depart = $mission->Date_depart;
        $Date_de_fin = $mission->Date_de_fin;
        $periods = self::date_range($Date_depart,$Date_de_fin);
        $accArray = [];
        for($i=0;$i<count($periods);$i++){
            $p = str_replace('/', '-', $periods[$i]);
            $jour = date('w', strtotime($p));
            $dateInserer = date(self::DATE_FORMAT, strtotime($p));
            foreach(self::JOUR_ACCOMPAGNEMENT as $plan){
                if((($i%6)+1) == $plan['Date']){
                    $com = $classement[$plan['place']-1];
                    $acc = [
                        'Id_de_la_mission'=>$idMission,
                        'Commercial'=>$com->Commercial,
                        'Coach'=>$coach,
                        'Date'=>$dateInserer,
                        'Heure_debut'=>$plan['Heure_debut'],
                        'Heure_fin'=>$plan['Heure_fin'],
                        'Ordre'=>$plan['Ordre']
                    ];
                    $accArray[] = $acc;
                }
            }
        }
        Accompagnement::insert($accArray);
        return true;
    }

    public static function generatePlanningOld($idMission,$coach,$personnels=null){
        if($personnels==null){
            $personnels = DetailMission::getPersonnelFromCoach($coach,$idMission);
        }
        $matricules = [];
        foreach($personnels as $p){
            if(isset($p['Matricule'])){
                $matricules[] = $p['Matricule'];
            }
            else{
                $matricules[] = $p->Matricule;
            }
        }
        $classement = Classement::getFromMatricules($idMission,$matricules);
        $mission = Mission::getFirst([['Id_de_la_mission',$idMission]]);
        $Date_depart = $mission->Date_depart;
        $Date_de_fin = $mission->Date_de_fin;
        $periods = self::date_range($Date_depart,$Date_de_fin);
        $accArray = [];
        foreach($periods as $period){
            $p = str_replace('/', '-', $period);
            $jour = date('w', strtotime($p));
            $dateInserer = date(self::DATE_FORMAT, strtotime($p));
            foreach(self::JOUR_ACCOMPAGNEMENT as $plan){
                if($jour == $plan['Date']){
                    $com = $classement[$plan['place']-1];
                    $acc = [
                        'Id_de_la_mission'=>$idMission,
                        'Commercial'=>$com->Commercial,
                        'Coach'=>$coach,
                        'Date'=>$dateInserer,
                        'Heure_debut'=>$plan['Heure_debut'],
                        'Heure_fin'=>$plan['Heure_fin'],
                        'Ordre'=>$plan['Ordre']
                    ];
                    $accArray[] = $acc;
                }
            }
        }
        Accompagnement::insert($accArray);
        return true;
    }

    public static function date_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y' ) {
        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);
        while( $current <= $last ) {
    
            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }
        return $dates;
    }

    public static function toFormatParJour($accs){
        $jours = [];
        for($i=0;$i+3<count($accs);$i+=4){
            $jour=[
                'Coach'=>$accs[$i]->Coach,
                'jour'=>$accs[$i]->Date,
                'matin'=>[
                    [
                        'Commercial'=>$accs[$i]->Commercial,
                        'Heure_debut'=>$accs[$i]->Heure_debut,
                        'Heure_fin'=>$accs[$i]->Heure_fin
                    ],
                    [
                        'Commercial'=>$accs[$i+1]->Commercial,
                        'Heure_debut'=>$accs[$i+1]->Heure_debut,
                        'Heure_fin'=>$accs[$i+1]->Heure_fin
                    ]    
                ],
                'apresMidi'=>[
                    [
                        'Commercial'=>$accs[$i+2]->Commercial,
                        'Heure_debut'=>$accs[$i+2]->Heure_debut,
                        'Heure_fin'=>$accs[$i+2]->Heure_fin
                    ],
                    [
                        'Commercial'=>$accs[$i+3]->Commercial,
                        'Heure_debut'=>$accs[$i+3]->Heure_debut,
                        'Heure_fin'=>$accs[$i+3]->Heure_fin
                    ]
                ]
            ];
            $jours[] =$jour;
        }
        return $jours;
    }

    public static function toFormatParJourAcc($acc){
        $jour=[
            'Coach'=>$accs[$i]->Coach,
            'jour'=>$accs[$i]->Date,
            'matin'=>[
                [
                    'Commercial'=>$accs[$i]->Commercial,
                    'Heure_debut'=>$accs[$i]->Heure_debut,
                    'Heure_fin'=>$accs[$i]->Heure_fin
                ],
                [
                    'Commercial'=>$accs[$i+1]->Commercial,
                    'Heure_debut'=>$accs[$i+1]->Heure_debut,
                    'Heure_fin'=>$accs[$i+1]->Heure_fin
                ]    
            ],
            'apresMidi'=>[
                [
                    'Commercial'=>$accs[$i+2]->Commercial,
                    'Heure_debut'=>$accs[$i+2]->Heure_debut,
                    'Heure_fin'=>$accs[$i+2]->Heure_fin
                ],
                [
                    'Commercial'=>$accs[$i+3]->Commercial,
                    'Heure_debut'=>$accs[$i+3]->Heure_debut,
                    'Heure_fin'=>$accs[$i+3]->Heure_fin
                ]
            ]
        ];
        return $jourgetFromMissionAndCoach;
    }
}