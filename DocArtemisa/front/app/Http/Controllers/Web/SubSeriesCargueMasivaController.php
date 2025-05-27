<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubSeriesCargueMasivaController extends Controller
{
    public function index()
    {
        // Aquí puedes pasar datos reales o quemados si quieres
        return view('SubSerieWeb.seriesCargueMasiva');
    }
}
