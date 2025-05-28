<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\SeriesController;
use App\Http\Controllers\Web\SubSeriesController;

use App\Http\Controllers\Web\TipoDocumentalController;
use App\Http\Controllers\Web\SeriesCargueMasivaController;
use App\Http\Controllers\Web\SubSeriesCargueMasivaController;



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
Route::get('/subSeriesWeb/masiva/seriesCargueMasiva', [SubSeriesCargueMasivaController::class, 'getAll'])->name('SubSerieWeb.seriescarguemasiva');
Route::get('/seriesWeb/masiva/detalle/{id}', [SeriesController::class, 'masiva'])->name('SerieWeb.masiva');

//SubSerie
Route::get('/subSeriesWeb', [SubSeriesController::class, 'index'])->name('SubSerieWeb.index');
Route::post('/subSeriesWeb', [SubSeriesController::class, 'store'])->name('SubSerieWeb.store');
Route::get('/subSeriesWeb/{id}/edit', [SubSeriesController::class, 'edit'])->name('SubSerieWeb.edit');
Route::put('/subSeriesWeb/{id}', [SubSeriesController::class, 'update'])->name('SubSerieWeb.update');
Route::delete('subSeriesWeb/{id}', [SubSeriesController::class, 'destroy'])->name('SubSerieWeb.destroy');

Route::get('/subSeriesWeb/masiva/detalle/{id}', [SubSeriesController::class, 'masiva'])->name('SubSerieWeb.masiva');
Route::post('/subSeriesWeb/masiva/procesarMasiva', [SubSeriesController::class, 'procesarMasiva'])->name('SubSerieWeb.procesarMasiva');
Route::get('/subSeriesWeb/masiva/exportar', [SubSeriesController::class, 'exportarMasiva'])->name('SubSerieWeb.exportar');
Route::post('/subSeriesWeb/subir', [SubSeriesController::class, 'subir'])->name('SubSerieWeb.subir');


Route::put('/subSeriesWeb/{id}', [SubSeriesController::class, 'update'])->name('SubSerieWeb.update');

Route::get('/subseries-cargue-masiva', [SubSeriesCargueMasivaController::class, 'index'])->name('SubSerieWeb.seriesCargueMasiva');

Route::get('/tipo-documental', [TipoDocumentalController::class, 'index'])->name('tipo_documental.index');
Route::get('/tipo-documental/{codigo}/edit', [App\Http\Controllers\Web\TipoDocumentalController::class, 'edit'])->name('tipoDocumental.edit');
