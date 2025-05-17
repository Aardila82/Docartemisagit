<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\SeriesCargueMasivaService;

use Illuminate\Http\Request;

class SeriesCargueMasivaControllerApi extends Controller
{
    protected $seriesCargueMasivaService;

    public function __construct(
        SeriesCargueMasivaService $seriesCargueMasivaService
    ) {
        $this->seriesCargueMasivaService = $seriesCargueMasivaService;
    }


    // Muestra todos los registros de archivos masivos
    public function getAll(Request $request)
{
    $perPage = $request->get('per_page', 10); // Se puede pasar por la URL
    $archivosMasivos = $this->seriesCargueMasivaService->getAll($perPage);
    return response()->json($archivosMasivos);
}

    // Guarda el nuevo archivo masivo en la base de datos
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'cantidad_registros' => 'required|integer',
            'nombre_archivo' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|max:255',
            'peso' => 'required|numeric',
            'mensaje_error' => 'required|string',
        ]);

        $data = [
            'cantidad_registros' => $request->cantidad_registros,
            'nombre_archivo' => $request->nombre_archivo,
            'nombre_usuario' => $request->nombre_usuario,
            'peso' => $request->peso,
            'mensaje_error' => $request->mensaje_error,
        ];
        $data = (Object)$data;
        $archivoMasivo = $this->seriesCargueMasivaService->store($data);

        // Respuesta en formato JSON
        return response()->json($archivoMasivo, 201); // Retorna el archivo creado con código HTTP 201
    }
}
