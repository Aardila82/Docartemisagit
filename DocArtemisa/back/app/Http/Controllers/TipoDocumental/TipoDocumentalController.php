<?php

namespace App\Http\Controllers\TipoDocumental;

use App\Http\Controllers\Controller;
use App\Services\TipoDocumentalService;
use Illuminate\Http\Request;

class TipoDocumentalController extends Controller
{
    protected $tipoDocumentalService;

    public function __construct(TipoDocumentalService $tipoDocumentalService)
    {
        $this->tipoDocumentalService = $tipoDocumentalService;
    }

    public function index()
    {
        $datos = $this->tipoDocumentalService->index();
        return response()->json($datos);
    }

   public function store(Request $request)
{
    $validatedData = $request->validate([
        'SGD_TPR_CODIGO' => 'required|integer|unique:SGD_TPR_TPDCUMENTO,SGD_TPR_CODIGO',
        'SGD_TPR_DESCRIP' => 'required|string',
        'SGD_TPR_TERMINO' => 'nullable|numeric',
        'SGD_TPR_NUMERA' => 'nullable|string|max:1',
        'SGD_TPR_RADICA' => 'nullable|string|max:1',
        'SGD_TPR_ESTADO' => 'nullable|integer',
        'idversion' => 'nullable|numeric',
        'estado_id' => 'nullable|integer|exists:estados,id',
    ]);

    $nuevoRegistro = $this->tipoDocumentalService->store($validatedData);

    return response()->json($nuevoRegistro, 201);
}

public function show($id)
{
    $registro = $this->tipoDocumentalService->findById($id);

    if (!$registro) {
        return response()->json(['message' => 'Registro no encontrado'], 404);
    }

    return response()->json($registro, 200);
}

public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'SGD_TPR_CODIGO' => 'required|integer',
        'SGD_TPR_DESCRIP' => 'required|string',
        'SGD_TPR_TERMINO' => 'nullable|numeric',
        'SGD_TPR_NUMERA' => 'nullable|string|max:1',
        'SGD_TPR_RADICA' => 'nullable|string|max:1',
        'SGD_TPR_ESTADO' => 'nullable|integer',
        'idversion' => 'nullable|numeric',
        'estado_id' => 'nullable|integer|exists:estados,id',
    ]);

    $registroActualizado = $this->tipoDocumentalService->update($id, $validatedData);

    if (!$registroActualizado) {
        return response()->json(['message' => 'Registro no encontrado'], 404);
    }

    return response()->json($registroActualizado, 200);
}

public function destroy($id)
{
    $registro = $this->tipoDocumentalService->delete($id);

    return response()->json([
        'message' => 'Tipo documental inactivado correctamente.',
        'data' => $registro
    ]);
}




}
