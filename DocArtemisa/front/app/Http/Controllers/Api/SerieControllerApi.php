<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Serie\SerieModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SerieControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $series = SerieModel::all();
        if ($series->isEmpty()) {
            $data = [
                "mensaje" => "No se tienen datos",
                "status" => 200
            ];
        } else {
            $data = [
                "actas" => $series,
                "status" => 200
            ];
        }

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación general (estado_id ahora es opcional)
        $validator = Validator::make($request->all(), [
            'idversion' => 'required|integer',
            'codigo' => 'required|integer',
            'descripcion' => 'required|string',
            'fechainicio' => 'required|date',
            'fechafin' => 'required|date|after_or_equal:fechainicio',
            'estado_id' => 'nullable|exists:estados,id', // Ya no es required
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        // Verificar si ya existe una serie con el mismo código, descripción vacía y estado diferente de 2
        $existe = SerieModel::where('codigo', $request->codigo)
            ->where('descripcion', $request->descripcion)
            ->where('estado_id', '!=', 2)
            ->exists();

        if ($existe) {
            return response()->json([
                'mensaje' => 'Ya existe una serie con ese código, descripción vacía y estado diferente de 2.',
                'status' => 409
            ], 409);
        }

        // Crear la nueva serie
        $serie = new SerieModel();
        $serie->idversion = $request->idversion;
        $serie->codigo = $request->codigo;
        $serie->estado_id = $request->estado_id ?? 0; // Valor por defecto si no se envía
        $serie->descripcion = $request->descripcion;
        $serie->fechainicio = $request->fechainicio;
        $serie->fechafin = $request->fechafin;
        $serie->save();

        return response()->json([
            'mensaje' => 'Serie creada correctamente',
            'serie' => $serie,
            'status' => 201
        ], 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $serie = SerieModel::find($id);

    if (!$serie) {
        return response()->json([
            'mensaje' => 'Serie no encontrada',
            'status' => 404
        ], 404);
    }

    // Validación (estado_id ahora es opcional)
    $validator = Validator::make($request->all(), [
        'idversion' => 'required|integer',
        'codigo' => 'required|integer',
        'descripcion' => 'required|string',
        'fechainicio' => 'required|date',
        'fechafin' => 'required|date|after_or_equal:fechainicio',
        'estado_id' => 'nullable|exists:estados,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors(),
            'status' => 400
        ], 400);
    }

    // Verificar si ya existe otra serie con el mismo código y descripción,
    // estado diferente de 2, y que no sea esta misma serie
    $existe = SerieModel::where('id', '!=', $id)
        ->where('codigo', $request->codigo)
        ->where('descripcion', $request->descripcion)
        ->where('estado_id', '!=', 2)
        ->exists();

    if ($existe) {
        return response()->json([
            'mensaje' => 'Ya existe otra serie con ese código, descripción y estado diferente de 2.',
            'status' => 409
        ], 409);
    }

    // Actualizar la serie
    $serie->idversion = $request->idversion;
    $serie->codigo = $request->codigo;
    $serie->estado_id = $request->estado_id ?? 0; // Por defecto 0
    $serie->descripcion = $request->descripcion;
    $serie->fechainicio = $request->fechainicio;
    $serie->fechafin = $request->fechafin;
    $serie->save();

    return response()->json([
        'mensaje' => 'Serie actualizada correctamente',
        'serie' => $serie,
        'status' => 200
    ], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $serie = SerieModel::find($id);

    if (!$serie) {
        return response()->json([
            'mensaje' => 'Serie no encontrada',
            'status' => 404
        ], 404);
    }

    $serie->delete();

    return response()->json([
        'mensaje' => 'Serie eliminada correctamente',
        'status' => 200
    ], 200);
}


/**
 * Exporta los datos de series a un archivo CSV para descarga masiva
 * 
 * @return StreamedResponse
 */



}
