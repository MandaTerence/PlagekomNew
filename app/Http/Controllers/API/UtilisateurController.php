<?php

namespace App\Http\Controllers\API;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\CustomAuthService;
use Illuminate\Support\Facades\Auth;

class UtilisateurController extends Controller
{
    public function register(Request $request)
    {
/// TO-DO register methods
       /*
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $success = true;
            $message = 'User register successfully';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
        */
    }

    /**
     * Login
     */
    public function login(Request $request,CustomAuthService $AuthService)
    {
        $matricule = $request->matricule;
        $password = $request->password;
        
        if(($matricule == null)||($matricule == '')){
            $success = false;
            $message = 'matricule vide';
        }
        else if(($password == null)||($password == '')){
            $success = false;
            $message = 'mot de passe vide';
        }
        else {
            $utilisateur = $AuthService->checkUtilisateur($matricule,$password);
            if($utilisateur){
                Auth::login($utilisateur);
                $success = true;
                $message = 'User login successfully'.$matricule.' p '.$password;
                //return redirect()->intended('home');
            }
            else {
                $success = false;
                $message = 'Mot de passe ou matricule incorrect' ;
            }
        }

        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }

    /**
     * Logout
     */
    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message = 'Successfully logged out';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }
}
