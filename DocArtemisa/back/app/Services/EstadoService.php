<?php

namespace App\Services;

use App\Models\Estado;
use Illuminate\Http\JsonResponse;

class EstadoService
{
    public function index(): JsonResponse
    {
        $estados = Estado::all();
        return response()->json($estados);
    }
}
