<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SubSerie\SubSerieVersionModel;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class SubSerieVersionControllerApi extends Controller
{
    // Mostrar todos los registros
    public function index()
    {
        return response()->json(SubSerieVersionModel::all(), 200);
    }

    // Mostrar un solo registro
    public function show($id)
    {
        $subSerie = SubSerieVersionModel::find($id);

        if (!$subSerie) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($subSerie, 200);
    }

    // Crear un nuevo registro
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_codigo_serie'     => 'required|integer',
            'codigo_subserie'     => 'required|integer',
            'descripcion'         => 'required|string|max:255',
            'fecha_inicio'        => 'required|date',
            'fecha_final'         => 'required|date|after_or_equal:fecha_inicio',
            'archivo_gestion'     => 'nullable|boolean',
            'archivo_central'     => 'nullable|boolean',
            'conservacion_total'  => 'nullable|boolean',
            'eliminacion'         => 'nullable|boolean',
            'microfilmacion'      => 'nullable|boolean',
            'seleccion'           => 'nullable|boolean',
            'procedimiento'       => 'nullable|string|max:1000',
            'version'             => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $subSerie = SubSerieVersionModel::create($request->all());
            return response()->json($subSerie, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el registro', 'details' => $e->getMessage()], 500);
        }
    }

    // Actualizar un registro existente
    public function update(Request $request, $id)
    {
        $subSerie = SubSerieVersionModel::find($id);

        if (!$subSerie) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'id_codigo_serie'     => 'required|integer',
            'codigo_subserie'     => 'required|integer',
            'descripcion'         => 'required|string|max:255',
            'fecha_inicio'        => 'required|date',
            'fecha_final'         => 'required|date|after_or_equal:fecha_inicio',
            'archivo_gestion'     => 'nullable|boolean',
            'archivo_central'     => 'nullable|boolean',
            'conservacion_total'  => 'nullable|boolean',
            'eliminacion'         => 'nullable|boolean',
            'microfilmacion'      => 'nullable|boolean',
            'seleccion'           => 'nullable|boolean',
            'procedimiento'       => 'nullable|string|max:1000',
            'version'             => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $subSerie->update($request->all());
            return response()->json($subSerie, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar el registro', 'details' => $e->getMessage()], 500);
        }
    }

    // Eliminar un registro
    public function destroy($id)
    {
        $subSerie = SubSerieVersionModel::find($id);

        if (!$subSerie) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        try {
            $subSerie->delete();
            return response()->json(['message' => 'Registro eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el registro', 'details' => $e->getMessage()], 500);
        }
    }
}
