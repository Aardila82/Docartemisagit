<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ActaControllerApi;
use App\Http\Controllers\Api\SerieControllerApi;
use App\Http\Controllers\API\SeriesCargueMasivaControllerAPi;
use App\Http\Controllers\API\EstadoControllerApi;
use App\Http\Controllers\Api\SubSerieVersionControllerApi;
use App\Http\Controllers\API\SubSeriesCargueMasivaControllerApi;

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

//Serie Masiva
Route::post('/serieMasivaAPI', [SerieControllerApi::class, 'importFromCSV']);
Route::get('/SeriesCargueMasivaAPI', [SeriesCargueMasivaControllerApi::class, 'getAll']);
Route::post('/SeriesCargueMasivaAPI', [SeriesCargueMasivaControllerApi::class, 'store']);



//=== Procesos para Sub Serie ==========
Route::get('/subSerieAPI',[SubSerieVersionControllerApi::class, 'index']);
Route::post('/subSerieAPI', [SubSerieVersionControllerApi::class, 'store']);
Route::get('/subSerieAPI/{id}', [SubSerieVersionControllerApi::class, 'show']);
Route::put('/suSerieAPI/{id}', [SubSerieVersionControllerApi::class, 'update']);
Route::delete('/subSerieAPI/{id}', [SubSerieVersionControllerApi::class, 'destroy']);

//Sub Serie Masiva
Route::post('/subSerieMasivaAPI', [SubSeriesCargueMasivaControllerApi::class, 'importFromCSV']);
Route::get('/subSeriesCargueMasivaAPI', [SubSeriesCargueMasivaControllerApi::class, 'getAll']);
Route::post('/subSeriesCargueMasivaAPI', [SubSeriesCargueMasivaControllerApi::class, 'store']);



Route::get('/estadoAPI', [EstadoControllerApi::class, 'index']);


