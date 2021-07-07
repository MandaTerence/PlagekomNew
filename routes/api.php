<?php

use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\UtilisateurController;
use App\Http\Controllers\API\FonctionController;
use App\Http\Controllers\API\EquipeController;
use App\Http\Controllers\API\MissionController;
use App\Http\Controllers\API\PersonnelController;
use App\Http\Controllers\API\ClassementController;
use App\Http\Controllers\API\ProduitController;
use App\Http\Controllers\API\ControleController;
use App\Http\Controllers\API\SanctionController;
use App\Http\Controllers\API\SanctionPersonnelController;

use Illuminate\Support\Facades\Route;


Route::post('login', [UtilisateurController::class, 'login']);
Route::post('register', [UtilisateurController::class, 'register']);
Route::post('logout', [UtilisateurController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'books', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [BookController::class, 'index']);
    Route::post('add', [BookController::class, 'add']);
    Route::get('edit/{id}', [BookController::class, 'edit']);
    Route::post('update/{id}', [BookController::class, 'update']);
    Route::delete('delete/{id}', [BookController::class, 'delete']);
});

Route::group(['prefix' => 'fonctions', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [FonctionController::class, 'index']);
});

Route::group(['prefix' => 'missions', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [MissionController::class, 'index']);
    Route::get('/getTaux', [MissionController::class, 'getTaux']);
    Route::get('/getAllTypesMission', [MissionController::class, 'getAllTypesMission']);
});

Route::group(['prefix' => 'personnels', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [PersonnelController::class, 'index']);
    Route::get('/getFirstWhere', [PersonnelController::class, 'getFirstWhere']);
    Route::get('/getPersonnelData', [PersonnelController::class, 'getPersonnelData']);
    Route::get('/getMatriculeByFonction', [PersonnelController::class, 'getMatriculeByFonction']);
    Route::get('/getEvaluation', [PersonnelController::class, 'getEvaluation']);
    Route::get('/getClassement', [PersonnelController::class, 'getClassement']);
    Route::get('/searchByFonction', [PersonnelController::class, 'searchByFonction']);
    Route::get('/getPersonnelFromCoach', [PersonnelController::class, 'getPersonnelFromCoach']);
    Route::get('/getAllFromMission', [PersonnelController::class, 'getAllFromMission']);
    Route::get('/getAllWithInfos', [PersonnelController::class, 'getAllWithInfos']);
    Route::get('/getPersonnelEnMission', [PersonnelController::class, 'getPersonnelEnMission']);
    Route::get('/getPersonnelLocaux', [PersonnelController::class, 'getPersonnelLocaux']);
    Route::get('/getAllSalaire', [PersonnelController::class, 'getAllSalaire']);
    Route::get('/getProposition', [PersonnelController::class, 'getProposition']);
    Route::get('/getMatricule', [PersonnelController::class, 'getMatricule']);
});

Route::group(['prefix' => 'equipe', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', [EquipeController::class, 'create']);
});

Route::group(['prefix' => 'classements', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', [ClassementController::class, 'create']);
    Route::get('/planning', [ClassementController::class, 'getPlanning']);
});

Route::group(['prefix' => 'controle', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', [ControleController::class, 'create']);
});

Route::group(['prefix' => 'produits', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [ProduitController::class, 'index']);
    Route::get('/getProduitByDesignation', [ProduitController::class, 'getProduitByDesignation']);
    Route::get('/getFirst', [ProduitController::class, 'getFirst']);
});

Route::group(['prefix' => 'sanction', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [SanctionController::class, 'getAll']);
});

Route::group(['prefix' => 'sanctionPersonnel', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', [SanctionPersonnelController::class, 'create']);
    Route::get('/getFromMatricule', [SanctionPersonnelController::class, 'getFromMatricule']);
    Route::delete('/delete', [SanctionPersonnelController::class, 'delete']);
    
});
