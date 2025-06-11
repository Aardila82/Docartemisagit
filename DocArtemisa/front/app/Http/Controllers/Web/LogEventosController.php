<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\LogEventoService;

class LogEventosController extends Controller
{
    protected $logEventosService;

    public function __construct(LogEventoService $logEventoService)
    {
        $this->logEventosService = $logEventoService;
    }

    public function index()
    {
        $eventos = $this->logEventosService->getAll();

        return view('LogEventos.index', compact('eventos'));
    }
}
