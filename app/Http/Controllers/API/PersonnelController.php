<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use App\Models\DetailMission;
use Illuminate\Http\Request;
use App\Helpers\ControllerHelper;
use Illuminate\Support\Facades\DB;
use App\Services\ClassementService;
use App\Services\PersonnelService;

class PersonnelController extends Controller
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

    public function getAllSalaire(Request $request){
        $personnels = PersonnelService::getAllSalaire();
        $response = [
            'success' => true,
            'personnels' => $personnels,
        ];
        return $response;
    }

    public function getPersonnelEnMission(Request $request){
        $personnels = PersonnelService::getPersonnelsMission("MISSION");
        $response = [
            'success' => true,
            'personnels' => $personnels,
        ];
        return $response;
    }

    public function getPersonnelLocaux(Request $request){
        $personnels = PersonnelService::getPersonnelsMission("LOCAL");
        $response = [
            'success' => true,
            'personnels' => $personnels,
        ];
        return $response;
    }

    public function getAllWithInfos(Request $request){
        $interval = getDateInterval(Personnel::$DAY_INTERVAL);
        $personnels = Personnel::selectRaw('personnel.Matricule,personnel.Nom,personnel.Prenom,Sum(detailvente.Quantite * prix.Prix_detail) as CA,Sum(detailvente.Quantite) as nbrProduit,count( DISTINCT facture.Id_de_la_mission ) as nbrMission')
        ->join('facture','facture.Matricule_personnel','like','personnel.Matricule')
        ->join('detailvente','detailvente.Facture','=','facture.id')
        ->join('prix','detailvente.ID_prix','=','prix.Id')
        ->whereBetween('facture.Date', [$interval->firstDate,$interval->lastDate])
        ->where('personnel.Fonction_actuelle','like','1')
        ->orWhere('personnel.Fonction_actuelle','like','6')
        ->groupBy('Matricule','Nom','Prenom')
        ->orderBy('CA','DESC')
        ->get();
        for($i=0;$i<count($personnels);$i++){
            $personnels[$i]->Place = $i+1;
            $personnels[$i]->CA = (int)$personnels[$i]->CA;
            $personnels[$i]->nbrProduit = (int)$personnels[$i]->nbrProduit;
            $personnels[$i]->getAssuidite();
        }
        $response = [
            'success' => true,
            'personnels' => $personnels,
        ];
        return $response;
    }

    public function index(Request $request){
        $personnels = Personnel::where(ControllerHelper::getConditions($request))
            ->take(self::DEFAULT_MAX_RESULT)
            ->get();
        return $personnels;
    }

    public function compareCA($pa,$pb){
        if ($pa->CA == $pb->CA) { 
            return 0;
        }
        return ($pa->CA > $pb->CA) ? -1 : 1;
    }

    public function getClassementOld(Request $request){
        $personnels = [];
        if(isset($request->Matricules)){
            $personnels = PersonnelService::getPersonnelFromMatricule($request->Matricules);
        }
        foreach($personnels as $personnel){
            if(isset($request->Produits)){
                $personnel->getAllCA($request->Produits);
            }
            else{
                $personnel->getAllCA();
            }
        }
        $classementTotal = ClassementService::getClassementTotal($personnels,self::DEFAULT_COEF);
        $classementGlobal = ClassementService::getClassementGlobal($personnels);
        $classementLocal = ClassementService::getClassementLocal($personnels);
        $classementMission = ClassementService::getClassementMission($personnels);
        $classementProduitMoinsCher = ClassementService::getClassementProduitMoinsCher($personnels);
        $classementProduitPlusCher = ClassementService::getClassementProduitPlusCher($personnels);
        //$classementProduits = ClassementService::getClassementProduits($personnels);

        $success = true;
        $message = 'resultat trouvé';

        $response = [
            'success' => $success,
            'personnels' => $personnels,
            'classementsReel' => $classementTotal,
            'classements'=> [
                //["titre"=>"classementTotal","classement"=>$classementTotal],
                ["titre"=>"classementGlobal","classement"=>$classementGlobal],
                ["titre"=>"classementLocal","classement"=>$classementLocal],
                ["titre"=>"classementMission","classement"=>$classementMission],
                ["titre"=>"classementProduitMoinsCher","classement"=>$classementProduitMoinsCher],
                ["titre"=>"classementProduitPlusCher","classement"=>$classementProduitPlusCher]
            ]
            //'classementProduit' =>$classementProduits
        ];
        
        return $response;
    }

    public function getProposition(Request $request){
        $interval = getDateInterval(30);
        $idType = $request->idType;
        $produits = $request->produits;
        $pourcentage = $request->pourcentage;
        $dateExclus = [];
        if($request->listeDateExclu){
            $dateExclus = $request->listeDateExclu;
        }
        if((isset($request->dateDebut))&&(isset($request->dateFin))){
            $interval = (object) [
                "lastDate" => $request->dateFin,
                "firstDate" => $request->dateDebut
            ];
        }
        $jourTravail = PersonnelService::getJourTravail($interval,$dateExclus);
        return [
            "mission" => Personnel::getProposition($idType,$interval,$pourcentage,$dateExclus,$produits),
            "interval" => $interval,
            "idType" => $idType,
            "dateExclu" => $dateExclus,
            "jourTravail" => $jourTravail
        ];
    }

    public function getEvaluation(Request $request){
        
        $equipeA = [];
        $interval = getDateInterval(30);
        $dateXclu = $request->listeDateExclu;
        $pourcentage = $request->pourcentage;
        $minimumVente = $request->minimumVente;
        
        if(!isset($pourcentage)){
            $pourcentage = 0;
        }
        if(!isset($minimumVente)){
            $minimumVente = 0;
        }
        if(!isset($dateXclu)){
            $dateXclu = [];
        }
        if((isset($request->Matricules))){
            $equipeA = PersonnelService::getPersonnelFromMatricule($request->Matricules);
        }
        if((isset($request->dateDebut))&&(isset($request->dateFin))){
            $interval = (object) [
                "lastDate" => $request->dateFin,
                "firstDate" => $request->dateDebut
            ];
        }

        $jourDeTravail = PersonnelService::getJourTravail($interval,$dateXclu);
        //$equipe = [];

        foreach($equipeA as $personnel){
            $personnel->getAllCA($interval,$dateXclu);
            $personnel->getNbrJourObjectifAtteint($interval,$dateXclu);
            $personnel->getPourcentageObjectif($jourDeTravail);
            $personnel->getNbrProduit($interval);
            $personnel->getStatutbimestriel();
            $personnel->getAssuidite();
            $personne = new Personnel();
            $personne->Matricule = $personnel->Matricule;
            //$equipe[] = $personne;
        }
        
        $classement = ClassementService::getEvaluation($equipeA,self::DEFAULT_COEF,$interval,$dateXclu,$pourcentage);

        $success = true;
        $message = 'resultat trouvé';
        $response = [
            'success' => $success,
            'nbrJourDeTravail' => $jourDeTravail,
            'classements' => $classement
        ];
        
        return $response;
    }

    public function getClassement(Request $request){
        $equipeA = [];
        $equipeB = [];
        $interval = getDateInterval(30);
        if((isset($request->matriculeA))&&(isset($request->matriculeB))){
            $equipeA = PersonnelService::getPersonnelFromMatricule($request->matriculeA);
            $equipeB = PersonnelService::getPersonnelFromMatricule($request->matriculeB);
        }
        if((isset($request->dateDebut))&&(isset($request->dateFin))){
            $interval = [
                "lastDate" => $request->dateDebut,
                "firstDate" => $request->dateFin
            ];
        }
        foreach($equipeA as $personnel){
            if(isset($request->Produits)){
                $personnel->getAllCA($request->Produits);
            }
            else{
                $personnel->getAllCA();
            }
        }
        foreach($equipeB as $personnel){
            if(isset($request->Produits)){
                $personnel->getAllCA($request->Produits);
            }
            else{
                $personnel->getAllCA();
            }
        }
        $resultatEquipeA = [
            'classementReel' => ClassementService::getClassementTotal($equipeA,self::DEFAULT_COEF),
            'classementDetail' =>[
                [
                    'nom' =>'classementGlobal',
                    'classement' => ClassementService::getClassementGlobal($equipeA)
                ]
                ,
                [
                    'nom' => 'classementLocal',
                    'classement' => ClassementService::getClassementLocal($equipeA)
                ]
                ,
                [
                    'nom' =>'classementMission',
                    'classement' => ClassementService::getClassementMission($equipeA)
                ]
            ]
        ];
        if(isset($request->Produits)){
            $resultatEquipeA->classementDetail[] = 
            [
                'nom' => 'classementProduitPlusCher',
                'classement' => ClassementService::getClassementProduitPlusCher($equipeA)
            ];
            $resultatEquipeA->classementDetail[] = 
            [
                'nom' => 'classementProduitPlusCher',
                'classement' => ClassementService::getClassementProduitPlusCher($equipeA)
            ];
        };
        $resultatEquipeB = [
            'classementReel' => ClassementService::getClassementTotal($equipeB,self::DEFAULT_COEF),
            'classementDetail' =>[
                [
                    'nom' =>'classementGlobal',
                    'classement' => ClassementService::getClassementGlobal($equipeB)
                ]
                ,
                [
                    'nom' => 'classementLocal',
                    'classement' => ClassementService::getClassementLocal($equipeB)
                ]
                ,
                [
                    'nom' =>'classementMission',
                    'classement' => ClassementService::getClassementMission($equipeB)
                ]
            ]
        ];
        if(isset($request->Produits)){
            $resultatEquipeA->classementDetail[] = 
            [
                'nom' => 'classementProduitPlusCher',
                'classement' => ClassementService::getClassementProduitPlusCher($equipeA)
            ];
            $resultatEquipeA->classementDetail[] = 
            [
                'nom' => 'classementProduitPlusCher',
                'classement' => ClassementService::getClassementProduitPlusCher($equipeA)
            ];
        };

        $success = true;
        $message = 'resultat trouvé';

        $response = [
            'success' => $success,
            'resultatEquipeA' => $resultatEquipeA,
            'resultatEquipeB' => $resultatEquipeB,
        ];
        
        return $response;
    }

    public function getClassementsss(Request $request){
        $personnels = [];
        if(isset($request->Matricules)){
            $donnee = $request->Matricules;
            foreach($donnee as $m){
                $conditions = [['Matricule','like',$m]];
                $p = Personnel::getFirstWithCA($conditions);
                if(isset($p)){
                    $personnels[] = $p;
                }
            }
            usort( $personnels, array( $this, 'compareCA' ) );

            for($i=0;$i<count($personnels);$i++){
                $personnels[$i]->place = $i+1;
            }
        }
        
        if(isset($request->Matricules)){
            $response = [
                'success' => true,
                'message' => 'resultat trouvé',
                'personnels' => $personnels,
            ];
            return response()->json($response);
        }
        else{
            $response = [
                'success' => false,
                'message' => 'aucun resultat trouvé '.$test,
                'personnels' => null,
            ];
            return response()->json($response);
        }
        return $personnels;
    }

    public function getFirstWhere(Request $request){
        $conditions = [];
        if(isset($request->criteres)){
            $donnee = json_decode($request->criteres);
            foreach($donnee as $column => $value){
                $conditions[] = [$column,'like',$value];
            }
        }
        $personnel = Personnel::getFirstWithCA($conditions);
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

    public function getPersonnelFromCoach(Request $request){
        if((isset($request->coach))&&(isset($request->idMission))){
            $coach = $request->coach;
            $idMission = $request->idMission;
            $personnels = DetailMission::getPersonnelFromCoach($coach,$idMission);
            if(count($personnels)>0){
                $response = [
                    'success' => true,
                    'message' => count($personnels).'result found',
                    'data' => $personnels,
                ];
                return $response;
            }
        }
        $response = [
            'success' => false,
            'message' => 'no result found',
            'data' => [],
        ];
        return $response;
    }

    public function getMatriculeByFonction(Request $request){
        if(isset($request->fonction)){
            $conditions = [];
            $conditions[] = ['Fonction_actuelle','=',$request->fonction];
            if(isset($request->search)){
                $conditions[] = ['Matricule','like','%'.$request->search.'%'];
            }
            $personnels = Personnel::getMatricules($conditions);
            $response = [
                'success' => true,
                'message' => count($personnels).' results founds',
                'personnels' => $personnels,
            ];
            return $response;
        }
        else{
            $response = [
                'success' => false,
                'message' => 'fonction vide',
            ];
            return $response;
        }
    }

    public function searchByFonction(Request $request){
        if(isset($request->fonction)){
            $conditions = [];
            $conditions[] = ['Fonction_actuelle','=',$request->fonction];
            if(isset($request->search)){
                $conditions[] = ['Matricule','like','%'.$request->fonction.'%'];
            }
            $data = Personnel::where($conditions)
            ->first();
            $success = true;
            if(empty($emptyArray)){
                $message = 'aucun element trouvé' ;
            }
            else{
                $message = 'recherhe reussit' ;
            }
        }
        else{
            $success = false;
            $message = 'fonction vide' ;
            $data = [];
        }
        $response = [
            'success' => $success,
            'message' => $message,
            'personnel' => $data,
        ];
        return response()->json($response);
    }

    public function getPersonnelData(Request $request){
        $personnel = Personnel::whereRaw("Matricule like '".$request->matricule."' ")
        ->first();
        $personnel->getDetailPersonnel();
        $personnel->getStatutbimestriel();
        $personnel->getStatutAnnuel();
        $personnel->getChiffreDAffaire();
        $personnel->getBonusMensuel();
        $personnel->getIndemnite();
        $personnel->getSanction();
        $personnel->getJourAbsence();
        $personnel->getMalusVente();
        if($personnel){
            $response = [
                'success' => true,
                'message' => 'resultat trouvé',
                'personnel' => $personnel,
            ];
            return $response;
        }
        else{
            $response = [
                'success' => false,
                'message' => 'aucun resultat trouvé',
                'personnel' => null,
            ];
            return $response;
        }
    }

    public function getAllFromMission(Request $request){
        $jour = $request->jour;
        $missions = PersonnelService::getAllFromMission($jour);
        $response = [
            'success' => true,
            'missions' =>$missions
        ];
        return $response;
    }

}
