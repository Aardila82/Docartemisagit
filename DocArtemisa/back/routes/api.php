<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ActaControllerApi;
use App\Http\Controllers\Api\SerieControllerApi;
use App\Http\Controllers\API\SeriesCargueMasivaControllerAPi;
use App\Http\Controllers\API\EstadoControllerApi;


//=== Procesos para el acta ==========
Route::get ('/actaAPI',[ActaControllerApi::class, 'index']);
Route::post('/actaAPI',[ActaControllerApi::class, 'store']);
Route::get('/actaAPI/{id}',[ActaControllerApi::class, 'show']);
Route::put('/actaAPI/{id}',[ActaControllerApi::class, 'update']);
Route::patch('/actaAPI/{id}',[ActaControllerApi::class, 'updatePartial']);
//=== Procesos para version ==========

//=== Procesos para Serie ==========
Route::get ('/serieAPI',[SerieControllerApi::class, 'index']);
Route::post('/serieAPI', [SerieControllerApi::class, 'store']);
Route::get('/serieAPI/{id}', [SerieControllerApi::class, 'show']);
Route::put('/serieAPI/{id}', [SerieControllerApi::class, 'update']);
Route::delete('/serieAPI/{id}', [SerieControllerApi::class, 'destroy']);


//Masivas
Route::post('/serieMasivaAPI', [SerieControllerApi::class, 'importFromCSV']);

Route::get('/SeriesCargueMasivaAPI', [SeriesCargueMasivaControllerApi::class, 'getAll']);
Route::post('/SeriesCargueMasivaAPI', [SeriesCargueMasivaControllerApi::class, 'store']);

Route::get('/estados', [EstadoControllerApi::class, 'index']);


