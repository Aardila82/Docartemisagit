<?php

namespace App\Services;

use App\Models\TipoDocumental\TipoDocumental;
use App\Services\LogEventoService;

class TipoDocumentalService
{
    protected $logEventoService;
    protected $evento_id_create;
    protected $evento_id_edit;

    protected $evento_id_delete;


    protected $entidad_id;
    protected $user;

    public function __construct(LogEventoService $logEventoService)
    {
        $this->logEventoService = $logEventoService;
        $this->evento_id_create = 1;
        $this->evento_id_edit = 2;
        $this->evento_id_delete = 3;


        $this->entidad_id = 3;
        $this->user = "USER";

    }

    // Método para listar todos los registros
    public function index()
    {
        return TipoDocumental::all();
    }

    public function store(array $data)
    {

        $dataLog = [
            'fecha_evento' => now(),
            'usuario' => $this->user,
            'evento_id' => $this->evento_id_create,
            'entidad_id' => $this->entidad_id,
            'comentario' => '',
            'json_data' => json_encode($data),
        ];

        $this->logEventoService->registrar($dataLog);

        return \App\Models\TipoDocumental\TipoDocumental::create($data);
    }

    public function findById($id)
    {
        return TipoDocumental::find($id);
    }

    public function update($id, array $data)
    {

        $registro = TipoDocumental::find($id);

        if (!$registro) {
            return null;
        }

        $registro->update($data);

        $dataLog = [
            'fecha_evento' => now(),
            'usuario' => $this->user,
            'evento_id' => $this->evento_id_edit,
            'entidad_id' => $this->entidad_id,
            'comentario' => '',
            'json_data' => json_encode($data),
        ];

        $this->logEventoService->registrar($dataLog);
        return $registro;
    }

    public function delete($id)
    {
        $registro = TipoDocumental::findOrFail($id);
        $registro->estado_id = 2; // Cambia a inactivo
        $registro->save();


        $dataLog = [
            'fecha_evento' => now(),
            'usuario' => $this->user,
            'evento_id' => $this->evento_id_delete,
            'entidad_id' => $this->entidad_id,
            'comentario' => '',
            'json_data' => json_encode($registro),
        ];
        $this->logEventoService->registrar($dataLog);

        return $registro;
    }




}
