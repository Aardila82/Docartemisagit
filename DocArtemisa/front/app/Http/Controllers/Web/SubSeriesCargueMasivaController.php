<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\SubSeriesCargueMasivaService;

class SubSeriesCargueMasivaController extends Controller
{

    public function getAll(SubSeriesCargueMasivaService $subSeriesCargueMasivaService)
    {
        $response = $subSeriesCargueMasivaService->getAll();
        //echo "<pre>" . print_r($response->getData(), true) . "</pre>";
        //die();
        $data = empty($response->getData()->data) ? [] : (object)$response->getData()->data;
        return view('SubSerieWeb.seriesCargueMasiva', compact('data'));
    }
}
