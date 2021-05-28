<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

use App\Models\Facture;
use App\Models\Produit;
use App\Models\Accompagnement;
use App\Models\Controle;

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

    public function getNbrProduit(){
        $nbrFb = DB::table("facture")
        ->selectRaw("coalesce(sum(detailvente.Quantite),0) as nbr")
        ->join("detailvente","detailvente.Facture","facture.Id")
        ->join("prix","detailvente.Id_prix","prix.Id")
        ->whereRaw("MONTH(CURRENT_DATE()) = MONTH(Date)")
        ->whereRaw("YEAR(CURRENT_DATE()) = YEAR(Date)")
        ->whereRaw("Facture.Matricule_personnel = '".$this->Matricule."' ")
        ->first()->nbr;
        // ->orWhereRaw("Facture.Ress_sec_oplg = '".$this->Matricule."'")
        $nbrTerrain = DB::table("facture")
        ->selectRaw("coalesce(sum(detailvente.Quantite),0) as nbr")
        ->join("detailvente","detailvente.Facture","facture.Id")
        ->join("prix","detailvente.Id_prix","prix.Id")
        ->whereRaw("MONTH(CURRENT_DATE()) = MONTH(Date)")
        ->whereRaw("YEAR(CURRENT_DATE()) = YEAR(Date)")
        ->whereRaw("Facture.Ress_sec_oplg = '".$this->Matricule."'")
        ->first()->nbr;
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
        ->select("Date")
        ->where("Matricule_personnel",$this->Matricule)
        ->orderBy("Date","ASC")
        ->first()->Date;
        $nbrJour = (int)DB::table("facture")
        ->selectRaw("count(distinct Date) as nbrJour")
        ->where("Matricule_personnel",$this->Matricule)
        ->first()->nbrJour;
        $nbrTravail = (int)DB::table("facture")
        ->selectRaw("count(distinct Date) as nbrJour")
        ->where("Matricule_personnel",$this->Matricule)
        ->whereRaw("")
        ->first()->nbrJour;
        $this->assuidite = ($nbrJour*100)/$nbrTravail;
    }

    public function getJourMission(){
        $this->jourMission = (int)DB::table("mission")
        ->selectRaw("Sum(DATEDIFF(Date_de_fin, Date_depart)+1-FLOOR(DATEDIFF(Date_de_fin,Date_depart)/7)) as jourMission")
        ->whereRaw("Id_de_la_mission in (select distinct Id_de_la_mission from facture where Matricule_personnel like '".$this->Matricule."')")
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
        ->where("detailmission.personnel","like",$this->Matricule)
        ->orderBy("Date_d_activation","desc")
        ->first()->Type_de_mission;
        $this->type = $type;
        if(isset($type)){
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
        ->whereRaw("DATE(sanction_personnel.date) like '".$jour."'")
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
        ->whereRaw("DATE(debut) like '".$jour."'")
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
            ->join("facture","facture.Id_facture","like","pointressource.Id_facture")
            ->where("pointressource.Matricule","like",$this->Matricule)
            ->whereRaw("YEAR(facture.Date) like ".$annee."")
            ->selectRaw(DB::raw('COALESCE(SUM(Eng+Pospect+Client_fidel),0) as pointAn'))
            ->first()->pointAn;
            $this->pointAnnuel = $pointAnnuel;
        }
    }
    (Y)
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
            ->join("facture","facture.Id_facture","like","pointressource.Id_facture")
            ->where("pointressource.Matricule","like",$this->Matricule)
            ->whereRaw("YEAR(facture.Date) like ".$annee."")
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
        ->where('Matricule','like',$this->Matricule)
        ->first();
        $this->Nom = $result->Nom;
        $this->Prenom = $result->Prenom;
        return $this->Nom.' '.$this->Prenom;
    }

    public function getAllCA($produits = []){
        $this->CAGlobal=$this->getCAGlobal();
        $this->CAMission=$this->getCAMission();
        $this->CALocal=$this->getCALocal();
        $produitFinaux = [];
        $CAProduitMoinsCher = 0;
        $CAProduitPlusCher = 0;
        foreach($produits as $produit){
            $CAProduit = $this->getCAselonProduit($produit);
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
        $this->CAProduitMoinsCher = $CAProduitMoinsCher;
        $this->CAProduitPlusCher = $CAProduitPlusCher;
        $this->CAProduit= $produitFinaux;
    }

    public function getCAGlobal(){
        $nbrJour=self::$DAY_INTERVAL;
        $interval = getDateInterval($nbrJour);
        $facture = DB::table('facture')
        ->where('facture.Matricule_personnel','like',$this->Matricule)
        ->whereBetween('facture.Date', [$interval->firstDate,$interval->lastDate])
        ->select(DB::raw('COALESCE(SUM(detailvente.Quantite * prix.Prix_detail),0) as CA'))
        ->join('detailvente', 'detailvente.Facture', '=', 'facture.id')
        ->join('prix', 'detailvente.ID_prix', '=', 'prix.Id')
        ->first();
        $CAGlobal = 0;
        if($facture->CA){
            $CAGlobal = $facture->CA;
        }
        return $CAGlobal;
    }

    public function getCAMission(){
        $nbrJour=self::$DAY_INTERVAL;
        $interval = getDateInterval($nbrJour);
        $facture = DB::table('facture')
        ->where('facture.Matricule_personnel','like',$this->Matricule)
        ->where('mission.Type_de_mission','like',self::$COLUMN_TYPE_MISSION['mission'])
        ->whereBetween('facture.Date', [$interval->firstDate,$interval->lastDate])
        ->select(DB::raw('COALESCE(SUM(detailvente.Quantite * prix.Prix_detail),0) as CA'))
        ->join('detailvente', 'detailvente.Facture', '=', 'facture.id')
        ->join('prix', 'detailvente.ID_prix', '=', 'prix.Id')
        ->join('mission','mission.Id_de_la_mission','like','facture.Id_de_la_mission')
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
        return $this->CATotal;
    }

    public function getCAselonProduit($Produit){
        if(isset($Produit)){
            $nbrJour=self::$DAY_INTERVAL;
            $interval = getDateInterval($nbrJour);
            $facture = DB::table('facture')
            ->where('facture.Matricule_personnel','like',$this->Matricule)
            ->whereBetween('facture.Date', [$interval->firstDate,$interval->lastDate])
            ->where('Produit.Code_produit','=',$Produit)
            ->select(DB::raw('COALESCE(SUM(detailvente.Quantite * prix.Prix_detail),0) as CA'))
            ->join('detailvente', 'detailvente.Facture', '=', 'facture.id')
            ->join('prix', 'detailvente.ID_prix', '=', 'prix.Id')
            ->join('produit', 'produit.Code_produit', '=', 'prix.Code_produit')
            ->join('mission','mission.Id_de_la_mission','like','facture.Id_de_la_mission')
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

    public function getCALocal(){
        $nbrJour=self::$DAY_INTERVAL;
        $interval = getDateInterval($nbrJour);
        $facture = DB::table('facture')
        ->where('facture.Matricule_personnel','like',$this->Matricule)
        ->whereBetween('facture.Date', [$interval->firstDate,$interval->lastDate])
        ->where('mission.Type_de_mission','like',self::$COLUMN_TYPE_MISSION['local'])
        ->select(DB::raw('COALESCE(SUM(detailvente.Quantite * prix.Prix_detail),0) as CA'))
        ->join('detailvente', 'detailvente.Facture', '=', 'facture.id')
        ->join('prix', 'detailvente.ID_prix', '=', 'prix.Id')
        ->join('mission','mission.Id_de_la_mission','like','facture.Id_de_la_mission')
        ->first();
        $CAMission = 0;
        if($facture->CA){
            $CAMission = $facture->CA;
        }
        return $CAMission;
    }

    static function getFirstWithCA($conditions){
        $personnel = self::where($conditions)
        ->select('Matricule', 'Nom', 'Prenom','Fonction_actuelle')
        ->first();
        if($personnel){
            $interval = getDateInterval(self::$DAY_INTERVAL);
            $facture = DB::table('facture')
            ->where('facture.Matricule_personnel',$personnel->Matricule)
            ->whereBetween('facture.Date', [$interval->firstDate,$interval->lastDate])
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

    public function getCA(){
        $interval = getDateInterval(self::$DAY_INTERVAL);
        $facture = DB::table('facture')
        ->where('facture.Matricule_personnel',$this->Matricule)
        ->whereBetween('facture.Date', [$interval->firstDate,$interval->lastDate])
        ->select(DB::raw('COALESCE(SUM(detailvente.Quantite * prix.Prix_detail),0) as CA'))
        ->join('detailvente', 'detailvente.Facture', '=', 'facture.id')
        ->join('prix', 'detailvente.ID_prix', '=', 'prix.Id')
        ->first();
        $this->CA = 0;
        if($facture->CA){
            $this->CA = $facture->CA;
        }
        return $personnel;
    }

    public function getFirstWhere(Request $request){
        $conditions = [];
        if(isset($request->criteres)){
            $donnee = json_decode($request->criteres);
            foreach($donnee as $column => $value){
                $conditions[] = [$column,'like',$value];
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
