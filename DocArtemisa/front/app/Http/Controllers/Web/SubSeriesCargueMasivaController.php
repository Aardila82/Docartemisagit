<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\SubSeriesCargueMasivaService;

class SubSeriesCargueMasivaController extends Controller
{

    public function getAll(SubSeriesCargueMasivaService $subSeriesCargueMasivaService)
    {
        $response = $subSeriesCargueMasivaService->getAll();
        $data = empty($response->getData()->data) ? [] : (object)$response->getData()->data->data;
        return view('SubSerieWeb.seriesCargueMasiva', compact('data'));
    }


}
