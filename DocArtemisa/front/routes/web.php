<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\SeriesController;
use App\Http\Controllers\Web\SeriesCargueMasivaController;

Route::get('/seriesWeb', [SeriesController::class, 'index'])->name('SerieWeb.index');
Route::post('/seriesWeb', [SeriesController::class, 'store'])->name('SerieWeb.store');
Route::get('/seriesWeb/{id}/edit', [SeriesController::class, 'edit'])->name('SerieWeb.edit');
Route::put('/seriesWeb/{id}', [SeriesController::class, 'update'])->name('SerieWeb.update');
//Route::delete('/seriesWeb/{id}', [SeriesController::class, 'destroy'])->name('SerieWeb.destroy');
Route::delete('seriesWeb/{id}', [SeriesController::class, 'destroy'])->name('SerieWeb.destroy');


Route::get('/seriesWeb/masiva/detalle/{id}', [SeriesController::class, 'masiva'])->name('SerieWeb.masiva');

// Procesar archivo CSV subido
Route::post('/seriesWeb/masiva/procesarMasiva', [SeriesController::class, 'procesarMasiva'])->name('SerieWeb.procesarMasiva');
Route::get('/seriesWeb/masiva/exportar', [SeriesController::class, 'exportarMasiva'])->name('SerieWeb.exportar');
//Route::get('/seriesWeb/masiva/prueba', [SeriesController::class, 'cargueMasiva'])->name('cargueMasivo');
Route::post('/seriesWeb/subir', [SeriesController::class, 'subir'])->name('series.subir');

// Masiva
Route::get('/seriesWeb/masiva/seriesCargueMasiva', [SeriesCargueMasivaController::class, 'getAll'])->name('SerieWeb.seriescarguemasiva');


