<?php

namespace App\Http\Controllers\Web; // Actualizado para la carpeta Web

use App\Http\Controllers\Controller;
use App\Services\SubSeriesCargaMasivaService;

class SeriesCargueMasivaController extends Controller
{

    public function getAll(SubSeriesCargaMasivaService $subseriesCargueMasivaService)
    {
        $response = $subseriesCargueMasivaService->getAll();
        $data = empty($response->getData()->data) ? [] : (object)$response->getData()->data->data;

        return view('SubSerieWeb.seriesCargueMasiva', compact('data'));
    }


}
