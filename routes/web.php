<?php

use App\Http\Controllers\Ejecicio1Controller;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\EvaluacionP1Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('factura', [FacturaController::class, 'index']);

Route::get('ejercicio1', [Ejecicio1Controller::class, 'index']);

Route::get('evaluacion1', [EvaluacionP1Controller::class, 'index']);

Route::get('evaluacion2', [EvaluacionP2Controller::class, 'index']);