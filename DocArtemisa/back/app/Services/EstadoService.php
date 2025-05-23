<?php

namespace App\Services;

use App\Models\Estado;
use Illuminate\Http\JsonResponse;

class EstadoService
{
    public function index()
    {
        return Estado::all();
    }
}
