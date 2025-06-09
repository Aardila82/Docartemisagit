<?php

namespace App\Services;

use App\Models\LogEvento;

class LogEventoService
{
    public function obtenerTodos()
    {
        return LogEvento::with(['evento', 'entidad'])->latest()->get();
    }
    /**
     * Registra un nuevo evento en la tabla log_eventos
     */
    public function registrar(array $data): LogEvento
    {
        return LogEvento::create([
            'fecha_evento' => $data['fecha_evento'] ?? now(),
            'usuario'      => $data['usuario'],
            'evento_id'    => $data['evento_id'],
            'entidad_id'   => $data['entidad_id'],
            'comentario'   => $data['comentario'] ?? null,
            'json_data'    => $data['json_data'] ?? null,
        ]);
    }
}
