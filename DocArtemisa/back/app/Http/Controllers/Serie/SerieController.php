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
    public function index(Request $request)
{
    $perPage = $request->get('per_page', 3); // valor por defecto: 3
    $page = $request->get('page', 1);        // valor por defecto: 1

    $seriesTrd = SerieModel::latest('id')->paginate($perPage, ['*'], 'page', $page);

    if ($seriesTrd->total() === 0) {
        $data = [
            'mensaje' => 'No se tienen datos',
            'status' => 200
        ];
    } else {
        $data = [
            'data' => $seriesTrd->items(), // solo los datos de esta página
            'current_page' => $seriesTrd->currentPage(),
            'last_page' => $seriesTrd->lastPage(),
            'per_page' => $seriesTrd->perPage(),
            'total' => $seriesTrd->total(),
            'next_page_url' => $seriesTrd->nextPageUrl(),
            'prev_page_url' => $seriesTrd->previousPageUrl(),
            'status' => 200
        ];
    }

    return response()->json($data, 200);
}

}

    /**
     * Show the form for creating a new resource.
     */

