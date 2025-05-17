<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SerieService;

use App\Models\Serie\SerieModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SerieControllerApi extends Controller
{

    protected $serieService;

    public function __construct(
        SerieService $serieService
    ) {
        $this->serieService = $serieService;
    }


   public function index(Request $request)
{
    $perPage = $request->get('per_page', 10); // valor por defecto: 10
    $page = $request->get('page', 1);         // valor por defecto: 1

    // Paginación directamente en el controlador
    $series = SerieModel::latest('id')->paginate($perPage, ['*'], 'page', $page);

    if ($series->total() === 0) {
        $data = [
            "mensaje" => "No se tienen datos",
            "status" => 200
        ];
    } else {
        $data = [
            "actas" => $series->items(), // solo los items de la página actual
            "current_page" => $series->currentPage(),
            "last_page" => $series->lastPage(),
            "per_page" => $series->perPage(),
            "total" => $series->total(),
            "next_page_url" => $series->nextPageUrl(),
            "prev_page_url" => $series->previousPageUrl(),
            "status" => 200
        ];

        //prueba git
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


    public function importFromCSV(Request $request)
    {
        // Validar que se haya enviado un archivo
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        // Procesar el archivo con el servicio
        $results = $this->serieService->importFromCSV(
            $request->file('csv_file')->getRealPath()
        );

        return response()->json([
            'mensaje' => 'Importación completada',
            'data' => $results,
            'status' => 200
        ], 200);
    }
}
