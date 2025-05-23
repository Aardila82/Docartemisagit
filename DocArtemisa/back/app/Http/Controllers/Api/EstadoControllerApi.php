<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EstadoService;
use Illuminate\Http\JsonResponse;

class EstadoControllerApi extends Controller
{
    protected EstadoService $estadoService;

    public function __construct(EstadoService $estadoService)
    {
        $this->estadoService = $estadoService;
    }

    public function index()
    {
        $data = $this->estadoService->index();
        return response()->json($data);

    }
}
