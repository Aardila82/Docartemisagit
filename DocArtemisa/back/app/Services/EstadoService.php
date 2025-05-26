<?php

namespace App\Services;

use App\Models\EstadoModel;
use Illuminate\Http\JsonResponse;

class EstadoService
{
    public function index()
    {
        return EstadoModel::all();
    }
}
