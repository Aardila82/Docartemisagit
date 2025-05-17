<?php

namespace App\Http\Controllers\Api\Serie;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Serie\SerieModel;
use App\Models\Version\versionTrdModel;

class SerieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las series (usando paginación)
        $seriesTrd = SerieModel::latest('id')->paginate(3);

        // Retornar la respuesta en formato JSON
        return response()->json([
            'data' => $seriesTrd,
        ], 200); // 200 es el código HTTP para "OK"
    }
}

    /**
     * Show the form for creating a new resource.
     */

