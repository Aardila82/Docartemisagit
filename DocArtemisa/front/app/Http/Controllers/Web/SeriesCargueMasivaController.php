<?php

namespace App\Http\Controllers\Web; // Actualizado para la carpeta Web

use App\Http\Controllers\Controller;
use App\Services\SeriesCargueMasivaService;

class SeriesCargueMasivaController extends Controller
{

    public function getAll(SeriesCargueMasivaService $seriesCargueMasivaService)
    {
        $response = $seriesCargueMasivaService->getAll();
        $data = empty($response->getData()->data) ? [] : (object)$response->getData()->data->data;
       // echo "<pre>".print_r($data , true)."</pre>";
        return view('SerieWeb.seriesCargueMasiva', compact('data'));
    }


}
