<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ClassementController;
use App\Models\Excel;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('{any}', function ($lien=""){
    if(str_starts_with($lien, "excel")){
        Excel::check($lien);
        //var_dump($request->all());
    }
    else{
        return view('app');
    }
})->where('any', '.*');
