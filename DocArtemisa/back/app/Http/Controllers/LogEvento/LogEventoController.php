<?php

namespace App\Http\Controllers\LogEvento;

use App\Http\Controllers\Controller;
use App\Services\LogEventoService;
use App\Models\Evento;
use App\Models\Entidad;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogEventoController extends Controller
{
    protected $logEventoService;

    public function __construct(LogEventoService $logEventoService)
    {
        $this->logEventoService = $logEventoService;
    }

    /**
     * Retorna todos los logs como JSON.
     */
    public function index(): JsonResponse
    {
        $logs = $this->logEventoService->obtenerTodos();
        return response()->json($logs);
    }

    /**
     * Retorna los datos necesarios para crear un log (eventos y entidades activas).
     */
    public function create(): JsonResponse
    {
        $eventos = Evento::where('activo', true)->get();
        $entidades = Entidad::where('activo', true)->get();

        return response()->json([
            'eventos' => $eventos,
            'entidades' => $entidades,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        // Validación básica
        $validated = $request->validate([
            'fecha_evento' => 'nullable|date',
            'usuario'      => 'required|string|max:255',
            'evento_id'    => 'required|integer|exists:eventos,id',
            'entidad_id'   => 'required|integer|exists:entidades,id',
            'comentario'   => 'nullable|string',
            'json_data'    => 'nullable|json',
        ]);

        $logEvento = $this->logEventoService->registrar($validated);

        return response()->json([
            'message' => 'Log evento creado correctamente',
            'data' => $logEvento,
        ], 201);
    }
}
