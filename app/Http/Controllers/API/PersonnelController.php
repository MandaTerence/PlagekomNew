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

    public function getClassement(Request $request){
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

    public function getClassementOld(Request $request){
        $classementGlobal = [];
        $classementLocal = [];
        $classementMission = [];
        $classementProduits = [];
        if(isset($request->Matricules)){
            $classementGlobal = ClassementService::getClassementGlobal($request->Matricules);
            $classementLocal = ClassementService::getClassementLocal($request->Matricules);
            $classementMission = ClassementService::getClassementMission($request->Matricules);
        }

        if(isset($request->Produits)){
            foreach($request->Produits as $produit){
                $classementProduits[] =
                [
                    "produit" => $produit,
                    "classement" => ClassementService::getClassementProduit($request->Matricules,$produit)
                ];
            }
        }

        $success = true;
        $message = 'resultat trouvé';

        $response = [
            'success' => $success,
            'message' => $message,
            'classementGlobal' =>$classementGlobal,
            'classementLocal' =>$classementLocal,
            'classementMission' =>$classementMission,
            'classementProduit' =>$classementProduits
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
        $testCA = 0;
        $testCAB = 0;
        if(isset($personnel)){
            $testCA = $personnel->getCAselonProduit('SYSTEMA TOOTHPASTE CHARCOAL');
            $testCAB = $personnel->getCAMission();
            $testCAC = $personnel->getCALocal();
        }
        if($personnel){
            $response = [
                'success' => true,
                'message' => 'resultat trouvé',
                'CA produit' => $testCA,
                'CA Mission' => $testCAB,
                'CA local' => $testCAC,
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

