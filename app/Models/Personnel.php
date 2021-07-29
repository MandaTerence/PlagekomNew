<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

use App\Models\Facture;
use App\Models\Produit;
use App\Models\Mission;
use App\Models\Accompagnement;
use App\Models\Controle;
use App\Services\ClassementService;
use App\Services\PersonnelService;

class Personnel extends Model
{
    use HasFactory,Notifiable;
    public static $DEFAULT_MAX_RESULT = 10;
    public static $DAY_INTERVAL = 190;
    const PRIX_CHER = 190;
    protected $table = 'personnel';
    protected $primaryKey = 'Matricule';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    const DEFAULT_COEF = [
        'global' => 5,
        'local' => 2,
        'mission' => 1,
        'produitPlusCher' => 1,
        'produitMoinsCher' => 1,
        'produit' => [],
        'typeMission' => 2
    ];
    const SALAIRE_NUMERATEUR = 8300;
    const SALAIRE_MISSION_DENOMINATEUR = 55000;
    const SALAIRE_LOCAL_DENOMINATEUR = 50000;
    const SALAIRE_EXTRA_DENOMINATEUR = 75000;

    public static $tabBis = [
        ['moisBis'=>[11,12]],
        ['moisBis'=>[11,12]],
        ['moisBis'=>[11,12]],
        ['moisBis'=>[1,2]],
        ['moisBis'=>[1,2]],
        ['moisBis'=>[3,4]],
        ['moisBis'=>[3,4]],
        ['moisBis'=>[5,6]],
        ['moisBis'=>[5,6]],
        ['moisBis'=>[7,8]],
        ['moisBis'=>[7,8]],
        ['moisBis'=>[9,10]],
        ['moisBis'=>[9,10]]
    ];

    protected $fillable = [
        'Date_d_embauche',
        'Nom',
        'Prenom',
        'Date_de_naissance',
        'Lieu_de_naissance',
        'Sexe',
        'Situation_Matrimoniale', 	   		 			   	
        'Nombre_d_enfant', 			   	
        'Cin_personnel',
        'Date_cin_personnel',
        'Lieu_delivrance_du_cin_personnel',
        'Date_duplicata_cin_personnel',
        'Lieu_de_dupliacata_cin_personnel',
        'Adresse_du_personnel',
        'Contact_du_personnel',
        'Nom_et_prenom_du_tuteur',
        'Lien_de_parente',
        'Cin_du_tuteur',		   	
        'Date_de_delivrance_cin_tuteur',
        'Adresse_du_tuteur',
        'Contact_du_tuteur',
        'Fonction_a_l_embauche',
        'Fonction_actuelle',
        'Mode_de_pass_login',
        'statut',
    ];

    public static $COLUMN_TYPE_MISSION = [
        "local"=>"LOCAL",
        "mission"=>"MISSION"
    ];

    public function getSalaire($mois,$annee,$malus){
        $salaires = Facture::selectRaw("coalesce(sum(prix.Prix_detail*detailvente.Quantite),0) as ca,Mission.Type_de_mission,facture.date,facture.Id_zone as Id_zone")
        ->join("detailvente","detailvente.Facture","facture.Id")
        ->join("prix","detailvente.Id_prix","prix.Id")
        ->join("Mission","facture.Id_de_la_mission","Mission.Id_de_la_mission")
        ->where("Facture.Matricule_personnel",$this->Matricule)
        ->whereRaw(" ".$mois." = MONTH(Date)")
        ->whereRaw(" ".$annee." = YEAR(Date)")
        ->groupBy(["Mission.Type_de_mission","facture.date","Id_zone"])
        ->get();

        $salaireTotal = 0;
        $malusVente = 0;

        foreach($salaires as $sal){
            if($sal->Type_de_mission == 'LOCAL'){
                $sal->montant = (($sal->ca)*(self::SALAIRE_NUMERATEUR))/(self::SALAIRE_LOCAL_DENOMINATEUR);
                $salaireTotal += $sal->montant;
            }
            else if($sal->Type_de_mission == 'MISSION'){
                $sal->montant = (($sal->ca)*(self::SALAIRE_NUMERATEUR))/(self::SALAIRE_MISSION_DENOMINATEUR);
                $salaireTotal += $sal->montant;
            }
            else if($sal->Type_de_mission == 'PROVINCE'){
                $sal->montant = (($sal->ca)*(self::SALAIRE_NUMERATEUR))/(self::SALAIRE_EXTRA_DENOMINATEUR);
                $salaireTotal += $sal->montant;
            }
            $sal->malusVente = 0;
            foreach($malus as $m){
                if(($sal->Id_zone == $m->Id_zone)&&($sal->ca < $m->montant_vente)){
                    $malusVente += $m->valeur_malus;
                    $sal->malusVente = $m->valeur_malus;
                    break;
                }
            }
        }
        $this->salaire = $salaireTotal;
        $this->malusVente = $malusVente;
        $this->salaires = $salaires;
    }

    public static function getPersonnelEnMission(){
        $personnelEnMission = [];
        $missionEncours = Mission::where('Statut','En_cours')
        ->get();
        foreach($missionEncours as $mission){
            $personnels = $mission->selectPersonnelFromMission()->get();
            foreach($personnels as $personnel){
                if((!in_array($personnel,$personnelEnMission))&&(!str_starts_with($personnel->personnel, 'COTN'))&&(!str_starts_with($personnel->personnel, 'COTN'))){
                    $p = new Personnel;
                    $p->Matricule = $personnel->personnel;
                    $personnelEnMission[] = $p;
                }
            }
        }
        return $personnelEnMission;
    }

    public function checkIfEnMission(){
        $dernierJour = DB::table("detailmission")
        ->join('MISSION','MISSION.Id_de_la_mission','=','detailmission.Id_de_la_mission')
        ->selectRaw('MISSION.Date_de_fin as fin')
        ->where('personnel',$this->Matricule)
        ->orderBy('MISSION.Date_de_fin','DESC')
        ->limit(1)
        ->first()->fin;
        $this->auRepos = (strtotime($dernierJour) < strtotime('now'));
        $this->dernierJourTravail = $dernierJour;
        return $this->auRepos;
    }

    public static function getProposition($idTypeMission,$interval,$taux,$dateExclus=[],$produits=[]){
        
        $propositions = [];
        $test=[];
        
        $personnelEnMission = self::getPersonnelEnMission();
        $missionDansInterval =  MISSION::getMissionBetween($interval);

        foreach($missionDansInterval as $mission){
            $personnelsDurantMission = $mission->getPersonnelFromMission();
            foreach($personnelsDurantMission as $pm){
                $personnel = new Personnel;
                $personnel->Matricule = $pm->Matricule;
                $exist = false;
                foreach($personnelEnMission as $comp){
                    if($comp->Matricule==$personnel->Matricule){
                        $exist = true;
                        break;
                    }
                }
                if(!$exist){
                    foreach($propositions as $comp){
                        if(trim($comp->Matricule)==trim($personnel->Matricule)){
                            $exist = true;
                            break;
                        }
                    }
                }
                if(
                    (!$exist)
                    &&(!str_starts_with($personnel->Matricule, 'COTN'))
                    &&(!str_starts_with($personnel->Matricule, 'cotn'))
                ){
                    $propositions[] = $personnel;
                }
            }
        }


        foreach($propositions as $proposition){
            $proposition->getNomFromMAtricule();
            $proposition->getAllCA($interval,$dateExclus,$produits,$idTypeMission);
        }

        $classements = ClassementService::getEvaluation($propositions,self::DEFAULT_COEF,$interval,$dateExclus,$taux);

        return $classements;
        /*
        $ClassementFinal = [];

        $PersonnelSurMissionDansInterval = [];
        $personnelEnMission = self::getPersonnelEnMission();

        $missionDansInterval =  MISSION::getMissionTypeBetween($idtypeMission,$interval);
        $jourDeTravail = PersonnelService::getJourTravail($interval,$dateExclus);

        foreach($missionDansInterval as $mission){
            $personnels = $mission->selectPersonnelFromMission()->get();
            foreach($personnels as $personnel){
                $p = new Personnel;
                $p->Matricule = $personnel->personnel;
                if((!str_starts_with($personnel->personnel, 'COTN'))&&(!str_starts_with($personnel->personnel, 'cotn'))){
                    $PersonnelSurMissionDansInterval[] = $p;
                }
            }
        }

        $personnelPrimaire = [];

        foreach($PersonnelSurMissionDansInterval as $personnel){
            $exist = false;
            foreach($personnelEnMission as $pm){
                if($pm->Matricule==$personnel->Matricule){
                    $personnelPrimaire
                }
            }
            if(){

            }
        }

        $personnelPrimaire = $PersonnelSurMissionDansInterval;
        $personnelSecondaire = self::getPersonnelSurInterval($interval,$PersonnelSurMissionDansInterval,$personnelEnMission,$dateExclus);

        foreach($personnelPrimaire as $personnel){
            $personnel->test="primaire";
        }

        foreach($personnelSecondaire as $personnel){
            $personnel->test="secondaire";
            $personnelPrimaire[] = $personnel;
        }

        foreach($personnelPrimaire as $personnel){
            $personnel->getAllCA($interval,$dateExclus,$produits,$idtypeMission);
            $personnel->getNbrJourObjectifAtteint($interval,$dateExclus);
        }
        $classements = ClassementService::getEvaluation($personnelPrimaire,self::DEFAULT_COEF,$interval,$dateExclus,$taux);

        //return $classements;

        return [
            //"Evaluation" => $classements,
            "test" => $PersonnelSurMissionDansInterval,
        ];

        /*
        $ClassementFinal = self::ajouterDansClassements($interval,$dateExclus,$personnelPrimaire,$ClassementFinal,$taux);
        $ClassementFinal = self::ajouterDansClassements($interval,$dateExclus,$personnelSecondaire,$ClassementFinal,$taux);
            return [
                "Evaluation" => $ClassementFinal,
                "PersonnelEnMission" => $personnelEnMission,
            ];
        */
    }

    public function existIn($comparaisons){
        foreach($comparaisons as $comparaison){
            if($this->Matricule==$comparaison->Matricule){
                return true;
                break;
            }
        }
        return false;
    }

    public static function ajouterDansClassements($interval,$dateXclu,$personnels,$classementFinal,$pourcentage=70){
        $classTemp = $classementFinal;
        foreach($personnels as $personnel){
            $personnel->getAllCA($interval,$dateXclu);
            $personnel->getNbrJourObjectifAtteint($interval,$dateXclu);
        }
        $classements = ClassementService::getEvaluation($personnels,self::DEFAULT_COEF,$interval,$dateXclu,$pourcentage);
        foreach($classements as $classement){
            $classTemp[] = $classement;
        }
        return $classTemp;
    }

    public static function getPersonnelSurInterval($interval,$personnelDejaPresent=[],$personnelEnMission=[],$dateXclu=[]){
        $personnelResult = [];

        $personnels = DB::table('facture')
        ->whereRaw("facture.Date >= '".$interval->firstDate."'")
        ->whereRaw("facture.Date <= '".$interval->lastDate."'")
        ->selectRaw(" Distinct facture.Matricule_personnel as personnel");
        foreach($dateXclu as $dateX){
            $personnels->whereRaw("facture.Date != '".$dateX."' ");
        }
        $personnels = $personnels->get();
        //return $personnels;
        foreach($personnels as $personnel){
            $p = new Personnel;
            $p->Matricule = $personnel->personnel;
            if((!in_array($p,$personnelDejaPresent))&&(!in_array($p,$personnelEnMission))&&(!str_starts_with($personnel->personnel, 'COTN'))&&(!str_starts_with($personnel->personnel, 'cotn'))){
                //$p->checkIfEnMission();
                //$p->getSelonTypeMission($idtypeMission,$interval,$dateExclus);
                //$p->getNbrJourObjectifAtteint($interval,$dateExclus);
                $personnelResult[] = $p;
            }
        }
        return $personnelResult;
    }

    public function getPourcentageObjectif($jourDeTravail){
        if(isset($this->nbrJourObjectif)){
            $this->pourcentageObjectif = (($this->nbrJourObjectif)*100)/$jourDeTravail;
        }
    }

    public static function getObjectif(){
        return DB::table('Objectif')
        ->get();
    }

    public static function getMalus(){
        $malus = DB::table('malus_detail')
        ->select('Id_zone','montant_vente','valeur_malus')
        ->join('malus','malus.Id','=','malus_detail.Id_malus')
        ->orderBy('montant_vente','asc')
        ->get();
        return $malus;
    }

    public function getNbrJourObjectifAtteint($interval="",$dateXclu=[]){
        $nbrObjectifAtteint = 0;
        $nbrJourNonAtteint = 0;
        $nbrJour=self::$DAY_INTERVAL;

        $objectifs = self::getObjectif();

        if($interval==""){
            $interval = getDateInterval($nbrJour);
        }

        $ventes = DB::table('facture')
        ->where('facture.Matricule_personnel',$this->Matricule)
        ->whereRaw("facture.Date >= '".$interval->firstDate."'")
        ->whereRaw("facture.Date <= '".$interval->lastDate."'")
        ->selectRaw("COALESCE(SUM(detailvente.Quantite * prix.Prix_detail),0) as CA,date,Id_zone")
        ->join('detailvente', 'detailvente.Facture', '=', 'facture.id')
        ->join('prix', 'detailvente.ID_prix', '=', 'prix.Id')
        ->groupBy('date','Id_zone')
        ->get();
        foreach($ventes as $vente){
            $exist = false;
            foreach($dateXclu as $date){
                if($vente->date==$date){
                    $exist = true;
                    break;
                }
            }
            if((!$exist)){
                foreach($objectifs as $obj){
                    if($vente->Id_zone==$obj->Id_zone){
                        if($vente->CA>=$obj->Montant){
                            $nbrObjectifAtteint+=1;
                        }
                        else{
                            $nbrJourNonAtteint+=1;
                        }
                        break;
                    }
                }
            }
        }
        $this->nbrJourNonAtteint = $nbrJourNonAtteint;
        $this->nbrJourObjectif = $nbrObjectifAtteint;
        $this->nbrJourTravailTotal = $this->nbrJourNonAtteint + $this->nbrJourObjectif;
        if($nbrJourNonAtteint+$nbrObjectifAtteint>0){
            $this->pourcentageObjectif = ($nbrObjectifAtteint*100)/($nbrJourNonAtteint+$nbrObjectifAtteint);
        }
        else{
            $this->pourcentageObjectif = 0;
        }
        return $nbrObjectifAtteint;
    }

    public function getMalusVente(){
        $malus = DB::table('malus_detail')
        ->select('Id_zone','montant_vente','valeur_malus')
        ->join('malus','malus.Id','=','malus_detail.Id_malus')
        ->orderBy('montant_vente','asc')
        ->get();

        $ventes = DB::table('facture')
        ->where('facture.Matricule_personnel',$this->Matricule)
        ->whereRaw("MONTH(CURRENT_DATE()) = MONTH(date)")
        ->whereRaw("YEAR(CURRENT_DATE()) = YEAR(date)")
        ->selectRaw("COALESCE(SUM(detailvente.Quantite * prix.Prix_detail),0) as CA,date,Id_zone")
        ->join('detailvente', 'detailvente.Facture', '=', 'facture.id')
        ->join('prix', 'detailvente.ID_prix', '=', 'prix.Id')
        ->groupBy('date','Id_zone')
        ->get();

        $montantMalus = 0;
        foreach($ventes as $vente){
            foreach($malus as $m){
                if(($vente->Id_zone == $m->Id_zone)&&($vente->CA < $m->montant_vente)){
                    $montantMalus += $m->valeur_malus;
                    break;
                }
            }
        }
        
        $this->malusVente = $montantMalus;
    }

    public function getSanction(){
        $sanctions = DB::table("sanction_personnel")
        ->join("sanction","sanction_personnel.id_sanction","=","sanction.Id")
        ->selectRaw("coalesce(sum(valeur),0) as sanctions")
        ->whereRaw("MONTH(CURRENT_DATE()) = MONTH(date)")
        ->whereRaw("YEAR(CURRENT_DATE()) = YEAR(date)")
        ->where("sanction_personnel.matricule_personnel",$this->Matricule)
        ->first()->sanctions;
        $this->sommeSanctions = (int)$sanctions;
    }

    public function getChiffreDAffaire(){
        $this->getCATerrain();
        $this->getCAFacebook();
        $this->getNbrProduit();
    }

    public function getNbrProduit($interval="",$dateXclu=[]){
        $nbrJour=self::$DAY_INTERVAL;
        if($interval==""){
            $interval = getDateInterval($nbrJour);
        }
        $nbrFb = DB::table("facture")
        ->selectRaw("coalesce(sum(detailvente.Quantite),0) as nbr")
        ->join("detailvente","detailvente.Facture","facture.Id")
        ->join("prix","detailvente.Id_prix","prix.Id")
        ->whereRaw("facture.Date >= '".$interval->firstDate."'")
        ->whereRaw("facture.Date <= '".$interval->lastDate."'")
        ->whereRaw("Facture.Matricule_personnel = '".$this->Matricule."' ");
        foreach($dateXclu as $dateX){
            $nbrFb->whereRaw("facture.Date != '".$dateX."' ");
        }
        $nbrFb = $nbrFb->first()->nbr;
        // ->orWhereRaw("Facture.Ress_sec_oplg = '".$this->Matricule."'")
        $nbrTerrain = DB::table("facture")
        ->selectRaw("coalesce(sum(detailvente.Quantite),0) as nbr")
        ->join("detailvente","detailvente.Facture","facture.Id")
        ->join("prix","detailvente.Id_prix","prix.Id")
        ->whereRaw("facture.Date >= '".$interval->firstDate."'")
        ->whereRaw("facture.Date <= '".$interval->lastDate."'")
        ->whereRaw("Facture.Ress_sec_oplg = '".$this->Matricule."'");
        foreach($dateXclu as $dateX){
            $nbrTerrain->whereRaw("facture.Date != '".$dateX."' ");
        }
        $nbrTerrain = $nbrTerrain->first()->nbr;

        $this->nbrProduitFb = (int)$nbrFb;
        $this->nbrProduitTerrain = (int)$nbrTerrain;
        $this->nbrProduit = $nbrTerrain + $nbrFb;
        return $this->nbrProduit;
    }

    public function getBonusMensuel(){
        if(!isset($this->idStatutMensuel)){
            $this->getStatutbimestriel();
        }
        $bonus = DB::table("Privilege_detail")
        ->selectRaw("coalesce(sum(valeur),0) as bonusMensuel")
        ->where("Id_type_privilege",1)
        ->where("Id_privilege",$this->idStatutMensuel)
        ->first()
        ;
        $this->bonusMensuel = (int)$bonus->bonusMensuel;
    }

    public function getCATerrain(){
        $this->CATerrain = DB::table("facture")
        ->selectRaw("coalesce(sum(prix.Prix_detail*detailvente.Quantite),0) as CATerrain")
        ->join("detailvente","detailvente.Facture","facture.Id")
        ->join("prix","detailvente.Id_prix","prix.Id")
        ->where("Facture.Matricule_personnel",$this->Matricule)
        ->where('Status','')
        ->whereRaw("MONTH(CURRENT_DATE()) = MONTH(Date)")
        ->whereRaw("YEAR(CURRENT_DATE()) = YEAR(Date)")
        ->first()->CATerrain;
        return $this->CATerrain;
    }

    public function getCAFacebook(){
        $this->CAFacebook = DB::table("facture")
        ->selectRaw("coalesce(sum(prix.Prix_detail*detailvente.Quantite),0) as CAFacebook")
        ->join("detailvente","detailvente.Facture","facture.Id")
        ->join("prix","detailvente.Id_prix","prix.Id")
        ->where("Facture.Ress_sec_oplg",$this->Matricule)
        ->where("Status","livre")
        ->whereRaw("MONTH(facture.Date) = MONTH(CURRENT_DATE())")
        ->whereRaw("YEAR(Date) = YEAR(CURRENT_DATE())")
        ->first()->CAFacebook;
        return $this->CAFacebook;
    }

    public function getAssuidite(){
        $dateDebut = DB::table("facture")
        ->selectRaw("DATE_SUB(Date, INTERVAL 1 DAY) as Date")
        ->where("Matricule_personnel",$this->Matricule)
        ->orderBy("Date","ASC")
        ->first();
        if($dateDebut){
            $dateDebut = $dateDebut->Date;
            $dateFin = DB::table("facture")
            ->selectRaw("DATE_ADD(Date, INTERVAL 1 DAY) as Date")
            ->where("Matricule_personnel",$this->Matricule)
            ->orderBy("Date","DESC")
            ->first()->Date;
            $nbrJour = (int)DB::table("facture")
            ->selectRaw("count(distinct Date) as nbrJour")
            ->where("Matricule_personnel",$this->Matricule)
            ->whereRaw("'".$dateDebut."' < Date")
            ->whereRaw("'".$dateFin."' > Date")
            ->first()->nbrJour;
            $nbrTravail = (int)DB::table("facture")
            ->selectRaw("count(distinct Date) as nbrJour")
            ->whereRaw("'".$dateDebut."' < Date")
            ->whereRaw("'".$dateFin."' > Date")
            ->first()->nbrJour;
            $this->assuidite = ($nbrJour*100)/$nbrTravail;
        }
        else{
            $this->assuidite = 0;
        }
        /*
        $jj = DB::table("facture")
        ->selectRaw("distinct Date")
        ->where("Matricule_personnel",$this->Matricule)
        ->whereRaw("'".$dateDebut."' < Date")
        ->get();
        $this->jj = $jj;

        $jj = DB::table("facture")
        ->selectRaw("distinct Date")
        ->whereRaw("'".$dateDebut."' < Date")
        ->get();
        $this->jj = $jj;
        */
    }

    public function getJourMission(){
        $this->jourMission = (int)DB::table("mission")
        ->selectRaw("Sum(DATEDIFF(Date_de_fin, Date_depart)+1-FLOOR(DATEDIFF(Date_de_fin,Date_depart)/7)) as jourMission")
        ->whereRaw("Id_de_la_mission in (select distinct Id_de_la_mission from facture where Matricule_personnel = '".$this->Matricule."')")
        ->first()->jourMission;
        return $this->jourMission;
    }

    public function getJourAbsence(){
        $nbrJour = (int)DB::table("facture")
        ->selectRaw("count(distinct Date) as nbrJour")
        ->where("Matricule_personnel",$this->Matricule)
        ->whereRaw("Month(Date) = Month(CURRENT_DATE)")
        ->whereRaw("YEAR(CURRENT_DATE()) = YEAR(Date)")
        ->first()->nbrJour;
        $nbrTravail = (int)DB::table("facture")
        ->selectRaw("count(distinct Date) as nbrJour")
        ->whereRaw("Month(Date) = Month(CURRENT_DATE)")
        ->whereRaw("YEAR(CURRENT_DATE()) = YEAR(Date)")
        ->first()->nbrJour;
        $this->nbrJourAbsence = $nbrTravail-$nbrJour;
        $type = DB::table("detailmission")
        ->select("Date_d_activation","Type_de_mission")
        ->join("mission","mission.Id_de_la_mission","=","detailmission.Id_de_la_mission")
        ->where("detailmission.personnel","=",$this->Matricule)
        ->orderBy("Date_d_activation","desc")
        ->first();
        //Type_de_mission
        if($type!=null){
            $type = $type->Type_de_mission;
            $this->type = $type;
            $malus = DB::table("malus_absence")
            ->select("Valeur")
            ->where("Designation",$type)
            ->first()->Valeur;
            $this->malusAbsence = $malus*$this->nbrJourAbsence;
        }
        
        else{
            $this->malusAbsence = 5000*$this->nbrJourAbsence;
        }
    }

    public function getIndemnite(){
        if(!isset($this->idStatutMensuel)){
            $this->getPointBis();
        }
        if(!isset($this->jourTravailMensuel)){
            $this->getJourTravailMensuel();
        }
        if(!isset($this->jourTravailLocaux)){
            $this->getJourTravaillocaux();
        }
        $bonus = DB::table("Privilege_detail")
        ->selectRaw("coalesce(sum(valeur),0) as bonus")
        ->where("Id_type_privilege",2)
        ->where("Id_privilege",$this->idStatutMensuel)
        ->first()
        ;
        $this->IndemniteNormaux = ((int)$bonus->bonus)*$this->jourTravailMensuel;
        $bonus = DB::table("Privilege_detail")
        ->selectRaw("coalesce(sum(valeur),0) as bonus")
        ->where("Id_type_privilege",7)
        ->where("Id_privilege",$this->idStatutMensuel)
        ->first()
        ;
        $this->Indemnitelocaux = ((int)$bonus->bonus)*$this->jourTravailLocaux;
    }

    public function getJourTravail(){
        $this->jourTravail = DB::table("facture")
        ->selectRaw("coalesce(count(distinct Date),0) as jourTravail")
        ->where("Matricule_personnel",$this->Matricule)
        ->first()->jourTravail;
        return $this->jourTravail;
    }

    public function getJourTravailMensuel(){
        $this->jourTravailMensuel = DB::table("facture")
        ->selectRaw("coalesce(count(distinct Date),0) as jourTravail")
        ->where("Matricule_personnel",$this->Matricule)
        ->whereRaw("MONTH(facture.Date) = MONTH(CURRENT_DATE())")
        ->whereRaw("YEAR(Date) = YEAR(CURRENT_DATE())")
        ->first()->jourTravail;
        return $this->jourTravailMensuel;
    }

    public function getJourTravaillocaux(){
        $this->jourTravailLocaux = DB::table("facture")
        ->join ("mission","facture.Id_de_la_mission","=","mission.Id_de_la_mission")
        ->selectRaw("coalesce(count(distinct Date),0) as jourTravail")
        ->where("Matricule_personnel",$this->Matricule)
        ->where("mission.type_de_mission","LOCAL")
        ->whereRaw("MONTH(facture.Date) = MONTH(CURRENT_DATE())")
        ->whereRaw("YEAR(Date) = YEAR(CURRENT_DATE())")
        ->first()->jourTravail;
        return $this->jourTravailLocaux;
    }

    public function getDetailSanction($jour='%'){
        $this->sanctions = SanctionPersonnel::select("sanction.code_sanction","sanction.titre","sanction.valeur","sanction.unite")
        ->where("sanction_personnel.matricule_personnel",$this->Matricule)
        ->whereRaw("DATE(sanction_personnel.date) = '".$jour."'")
        ->join("sanction","sanction.id","=","sanction_personnel.id_sanction")
        ->get();
        if(isset($this->sanctions)){
            return true;
        }else{
            return false;
        }
    }

    public function getDetailControl($jour='%'){
        $this->controles = Controle::selectRaw("sim,debut,fin,TIMEDIFF(fin,debut) as duree")
        ->where("commercial",$this->Matricule)
        ->whereRaw("DATE(debut) = '".$jour."'")
        ->get();
        if(isset($this->controles)){
            return true;
        }else{
            return false;
        }
    }

    public function getStatutAnnuel(){
        if(!isset($this->statutAnnuel)){
            $this->getPointAnn();
            if($this->pointAnnuel == 0){
                $this->statutAnnuel = "Natural";
            }
            else{
                $stat = DB::Table("privillege")
                ->select("Designation","Id")
                ->where('Point_initial', '<', $this->pointAnnuel)
                ->where('Point_final','>=', $this->pointAnnuel)
                ->where('Periode','Annuel')
                ->first();
                $this->statutAnnuel = $stat->Designation;
                $this->idStatutAnnuel = $stat->Id;
            }
        }
    }

    public function getPointAnn(){
        if(!isset($this->pointAnnuel)){
            $annee = date('Y');
            $pointAnnuel = DB::Table("pointressource")
            ->join("facture","facture.Id_facture","=","pointressource.Id_facture")
            ->where("pointressource.Matricule","=",$this->Matricule)
            ->whereRaw("YEAR(facture.Date) = ".$annee."")
            ->selectRaw(DB::raw('COALESCE(SUM(Eng+Pospect+Client_fidel),0) as pointAn'))
            ->first()->pointAn;
            $this->pointAnnuel = $pointAnnuel;
        }
    }

    public function getPointBis(){
        if(!isset($this->pointMensuel)){
            $moisActuel = date('n');
            $annee = '';
            if(($moisActuel == 1)||($moisActuel == 2)){
                $annee = date('Y', strtotime('-1 year'));
            }
            else{
                $annee = date('Y');
            }
            $moisBis = self::$tabBis[$moisActuel]['moisBis'];
            $pointMensuel = DB::Table("pointressource")
            ->join("facture","facture.Id_facture","=","pointressource.Id_facture")
            ->where("pointressource.Matricule","=",$this->Matricule)
            ->whereRaw("YEAR(facture.Date) = ".$annee."")
            ->WhereRaw("MONTH(facture.Date) in (".$moisBis[0].",".$moisBis[1].")")
            ->selectRaw(DB::raw('COALESCE(SUM(Eng+Pospect+Client_fidel),0) as pointBis'))
            ->first()->pointBis;
            $this->pointMensuel = $pointMensuel;
        }
    }

    public function getStatutbimestriel(){
        if(!isset($this->statutbimestriel)){
            $this->getPointBis();
            if($this->pointMensuel == 0){
                $this->statutMensuel = "Beginner";
            }
            else{
                $stat = DB::Table("privillege")
                ->select("Designation","Id")
                ->where('Point_initial', '<', $this->pointMensuel)
                ->where('Point_final','>=', $this->pointMensuel)
                ->where('Periode','Bimestriels')
                ->first();
                $this->statutMensuel = $stat->Designation;
                $this->idStatutMensuel = $stat->Id;
            }
        }
    }

    public function getDetailPersonnel(){
        $detail = Accompagnement::select('Id_de_la_mission','Coach')
        ->where('Commercial',$this->Matricule)
        ->orderBy('Date','asc')
        ->first();
        if(isset($detail->Id_de_la_mission)){
            $this->Id_de_la_mission = $detail->Id_de_la_mission;
            $this->Coach = $detail->Coach;
            $this->ContactCoach = self::select('Contact_du_personnel')
            ->where('Matricule',$detail->Coach)
            ->first()->Contact_du_personnel;
        }
        else{
            $idMiss = DB::table("equipe_temporaire")
            ->select("Id_de_la_mission")
            ->where("matricule_personnel",$this->Matricule)
            ->first();
            if(isset($idMiss->Id_de_la_mission)){
                $this->Id_de_la_mission = $idMiss->Id_de_la_mission;
            }
            $this->Coach = "aucun";
            $this->ContactCoach = "aucun";
        }
        return $detail;
    }

    public function getNomFromMAtricule(){
        $result = self::select('Nom','Prenom')
        ->where('Matricule','=',$this->Matricule)
        ->first();
        if(isset($result->Nom)){
            $this->Nom = $result->Nom;
            $this->Prenom = $result->Prenom;
            return $this->Nom.' '.$this->Prenom;
        }
    }
    
    public function getAllCA($interval="",$dateXclu=[],$produits = [],$idType=""){
        $nbrJour=self::$DAY_INTERVAL; 
        if($interval==""){
            $interval = getDateInterval($nbrJour);
        }
        $this->CAGlobal=(int)$this->getCAGlobal($interval,$dateXclu);
        $this->CAMission=(int)$this->getCAMission($interval,$dateXclu);
        $this->CALocal=(int)$this->getCALocal($interval,$dateXclu);
        
        if($idType!=""){
            $this->CASelonType = (int)$this->getSelonTypeMission($idType,$interval,$dateXclu);
        }
        
        $produitFinaux = [];
        
        $CAProduitMoinsCher = 0;
        $CAProduitPlusCher = 0;
        if(isset($produits)){
            foreach($produits as $produit){
                $CAProduit = $this->getCAselonProduit($produit,$interval);
                $produitFinaux[] = [
                    "Code_roduit" =>$produit,
                    "CAProduit" => $CAProduit
                ];
                $pr = Produit::getFirstWhere([['produit.Code_produit',$produit]]);
                if($pr->prix<self::PRIX_CHER){
                    $CAProduitMoinsCher += $CAProduit;
                }
                else{
                    $CAProduitPlusCher += $CAProduit;
                }
            }
        }
       
        $this->CAProduitMoinsCher = $CAProduitMoinsCher;
        $this->CAProduitPlusCher = $CAProduitPlusCher;
        $this->CAProduit = $produitFinaux;

        $this->getNbrJourObjectifAtteint($interval,$dateXclu);
        $this->getCAMoyen();
    }

    public function getCAMoyen(){
        if(
            ($this->CAGlobal)
            &&($this->nbrJourTravailTotal)
        ){
            $this->CAMoyen = $this->CAGlobal/$this->nbrJourTravailTotal;
        }
    }

    public function getCABase($interval="",$dateXclu=[]){
        $nbrJour=self::$DAY_INTERVAL;
        if($interval==""){
            $interval = getDateInterval($nbrJour);
        }
        $facture = DB::table('facture')
        ->where('facture.Matricule_personnel',$this->Matricule)
        ->whereRaw("facture.Date >= '".$interval->firstDate."'")
        ->whereRaw("facture.Date <= '".$interval->lastDate."'")
        ->select(DB::raw('COALESCE(SUM(detailvente.Quantite * prix.Prix_detail),0) as CA'))
        ->join('detailvente', 'detailvente.Facture', '=', 'facture.id')
        ->join('prix', 'detailvente.ID_prix', '=', 'prix.Id');
        foreach($dateXclu as $dateX){
            $facture->whereRaw("facture.Date != '".$dateX."' ");
        }
        return $facture;
    }

    public function getCAGlobal($interval="",$dateXclu=[]){
        $nbrJour=self::$DAY_INTERVAL;
        if($interval==""){
            $interval = getDateInterval($nbrJour);
        }
        $facture = $this->getCABase($interval,$dateXclu)
        ->first();
        $CAGlobal = 0;
        if($facture->CA){
            $CAGlobal = $facture->CA;
        }
        return $CAGlobal;
    }

    public function getCAMission($interval="",$dateXclu=[]){
        $nbrJour=self::$DAY_INTERVAL;
        if($interval==""){
            $interval = getDateInterval($nbrJour);
        }
        $facture = $this->getCABase($interval,$dateXclu)
        ->join('mission','mission.Id_de_la_mission','=','facture.Id_de_la_mission')
        ->where('mission.Type_de_mission','=',self::$COLUMN_TYPE_MISSION['mission'])
        ->first();
        $CAMission = 0;
        if($facture->CA){
            $CAMission = $facture->CA;
        }
        return $CAMission;
    }
 
    public function getCATotal($coef){
        $this->CATotal = 0
            +($this->CAGlobal*$coef['global'])
            +($this->CAMission*$coef['mission'])
            +($this->CALocal*$coef['local'])
            +($this->CAProduitPlusCher*$coef['produitPlusCher'])
            +($this->CAProduitMoinsCher*$coef['produitMoinsCher']);
        if($this->CASelonType){
            $this->CATotal = $this->CATotal + ($this->CASelonType*$coef['typeMission']);
        }
        return $this->CATotal;
    }

    public function getCAselonProduit($interval="",$Produit=[]){
        if(isset($Produit)){
            $nbrJour=self::$DAY_INTERVAL;
            if($interval==""){
                $interval = getDateInterval($nbrJour);
            }
            $facture = DB::table('facture')
            ->where('facture.Matricule_personnel','=',$this->Matricule)
            ->whereRaw("facture.Date >= '".$interval->firstDate."'")
            ->whereRaw("facture.Date <= '".$interval->lastDate."'")
            ->where('Produit.Code_produit','=',$Produit)
            ->select(DB::raw('COALESCE(SUM(detailvente.Quantite * prix.Prix_detail),0) as CA'))
            ->join('detailvente', 'detailvente.Facture', '=', 'facture.id')
            ->join('prix', 'detailvente.ID_prix', '=', 'prix.Id')
            ->join('produit', 'produit.Code_produit', '=', 'prix.Code_produit')
            ->join('mission','mission.Id_de_la_mission','=','facture.Id_de_la_mission')
            ->first();
            $CAMission = 0;
            if($facture->CA){
                $CAMission = $facture->CA;
            }
            return $CAMission;
        }
        else{
            return 0;
        }
    }

    public function getSelonTypeMission($idType="",$interval="",$dateXclu=[]){
        if($idType!=""){
            if($interval==""){
                $nbrJour=self::$DAY_INTERVAL;
                $interval = getDateInterval($nbrJour);
            }
            $facture = $this->getCABase($interval,$dateXclu)
            ->where('Id_type',$idType)
            ->join('mission','mission.Id_de_la_mission','=','facture.Id_de_la_mission')
            ->first();
            $CASelonType = 0;
            if($facture->CA){
                $CASelonType = $facture->CA;
            }
            $this->CASelonType = $CASelonType;
            return $CASelonType;
        }
    }

    public function getCALocal($interval="",$dateXclu=[]){
        if($interval==""){
            $nbrJour=self::$DAY_INTERVAL;
            $interval = getDateInterval($nbrJour);
        }
        $facture = $this->getCABase($interval,$dateXclu)
        ->where('mission.Type_de_mission','=',self::$COLUMN_TYPE_MISSION['local'])
        ->join('mission','mission.Id_de_la_mission','=','facture.Id_de_la_mission')
        ->first();
        $CAMission = 0;
        if($facture->CA){
            $CAMission = $facture->CA;
        }
        return $CAMission;
    }

    static function getFirstWithCA($conditions,$interval=""){
        $nbrJour = self::$DAY_INTERVAL;
        $personnel = self::where($conditions)
        
        ->select('Matricule', 'Nom', 'Prenom','Fonction_actuelle')
        ->first();
        if($personnel){
            if($interval==""){
                $interval = getDateInterval($nbrJour);
            }
            //$interval = getDateInterval(self::$DAY_INTERVAL);
            $facture = DB::table('facture')
            ->where('facture.Matricule_personnel',$personnel->Matricule)
            ->whereRaw("facture.Date >= '".$interval->firstDate."'")
        ->whereRaw("facture.Date <= '".$interval->lastDate."'")
            ->select(DB::raw('COALESCE(SUM(detailvente.Quantite * prix.Prix_detail),0) as CA'))
            ->join('detailvente', 'detailvente.Facture', '=', 'facture.id')
            ->join('prix', 'detailvente.ID_prix', '=', 'prix.Id')
            ->first();
            $personnel->CA = 0;
            if($facture->CA){
                $personnel->CA = $facture->CA;
            }
            return $personnel;
        }
    }

    public function getCA($interval=""){
        $nbrJour=self::$DAY_INTERVAL;
        if($interval==""){
            $interval = getDateInterval($nbrJour);
        }
        $facture = $this->getCABase($interval)
        ->first();
        $CA = 0;
        if($facture->CA){
            $CA= $facture->CA;
        }
        $this->CA = $CA;
    }

    public function getFirstWhere(Request $request){
        $conditions = [];
        if(isset($request->criteres)){
            $donnee = json_decode($request->criteres);
            foreach($donnee as $column => $value){
                $conditions[] = [$column,'=',$value];
            }
        }
        $personnel = Personnel::where($conditions)
            ->first();
        if($personnel){
            $response = [
                'success' => true,
                'message' => 'resultat trouvé',
                'personnel' => $personnel,
            ];
            return response()->json($response);
        }
        else{
            $response = [
                'success' => false,
                'message' => 'aucun resultat trouvé '.$request->criteres,
                'personnel' => null,
            ];
            return response()->json($response);
        }
    }

    public static function getMatricules($conditions = []){
        $nbrOfResult = self::$DEFAULT_MAX_RESULT;
        if($nbrOfResult == 'all'){
            return self::select('Matricule')
            ->where($conditions)
            ->get();
        }else{
            return self::select('Matricule')
            ->where($conditions)
            ->take($nbrOfResult)
            ->get();
        }
    }

}
