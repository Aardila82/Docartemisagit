<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Serie\SerieModel;
use Illuminate\Http\Request;
use App\Services\SerieService;
use Illuminate\Support\Facades\Validator;
use App\Models\Estado;

class SeriesController extends Controller
{

    protected $serieService;

    public function __construct(
        SerieService $serieService
    ) {
        $this->serieService = $serieService;
    }

    public function index(SerieService $serieService)
    {
        $response = $serieService->getAllSeries();
        $series = empty($response->getData()->data->actas) ? [] : (object)$response->getData()->data->actas;

        return view('SerieWeb.index', compact('series'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|integer',
            'descripcion' => 'required|string',
            'fechainicio' => 'required|date',
            'fechafin' => 'required|date|after_or_equal:fechainicio',
            'estado_id' => 'nullable|exists:estados,id',
        ]);

        $data = [
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'fechainicio' => $request->fechainicio,
            'fechafin' => $request->fechafin,
            'estado_id' => $request->estado_id ?? 0,
        ];

        $response = $this->serieService->createSerie($data);
        //dd($response);
        return redirect()->route('SerieWeb.index')
            ->with('success', $response->status() == 201 ? true : false) // true/false
            ->with('message', $response->getData()->data); // mensaje
    }

    public function edit($id)
{
    $serie = SerieModel::findOrFail($id);
    $estados = Estado::all(); // Trae los estados para el select
    return view('SerieWeb.edit', compact('serie', 'estados'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'idversion' => 'required|integer',
        'codigo' => 'required|integer',
        'descripcion' => 'required|string',
        'fechainicio' => 'required|date',
        'fechafin' => 'required|date|after_or_equal:fechainicio',
        'estado_id' => 'nullable|exists:estados,id',
    ]);

    $existe = SerieModel::where('id', '!=', $id)
        ->where('codigo', $request->codigo)
        ->where('descripcion', $request->descripcion)
        ->where('estado_id', '!=', 2)
        ->exists();

    if ($existe) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['conflicto' => 'Ya existe otra serie con ese código y descripción.']);
    }

    $serie = SerieModel::findOrFail($id);
    $serie->update([
        'idversion' => $request->idversion,
        'codigo' => $request->codigo,
        'descripcion' => $request->descripcion,
        'fechainicio' => $request->fechainicio,
        'fechafin' => $request->fechafin,
        'estado_id' => $request->estado_id ?? 0,
    ]);

    return redirect()->route('SerieWeb.index')->with('success', 'Serie actualizada correctamente.');
}

    public function destroy($id)
    {
        $serie = SerieModel::findOrFail($id);

        // Validar que estado_id no sea 1 ni 2
        if (in_array($serie->estado_id, [1, 2])) {
            return redirect()->route('SerieWeb.index')
                ->with('error', 'No se puede eliminar una serie con estado Activo o Inactivo.');
        }

        $serie->delete();

        return redirect()->route('SerieWeb.index')
            ->with('success', 'Serie eliminada correctamente.');
    }


    public function masiva($id)
    {

        /*$response = $serieService->getAllSeries();
    $series = empty($response->getData()->data->actas) ? [] : (object)$response->getData()->data->actas;
    */

        $series = SerieModel::all();

        // Crear contenido CSV desde las series
        $csv = [];
        $csv[] = ['codigo', 'descripcion', 'fechainicio', 'fechafin']; // encabezado

        foreach ($series as $serie) {
            $csv[] = [
                // $serie->idversion,
                $serie->codigo,
                $serie->descripcion,
                $serie->fechainicio,
                $serie->fechafin,
                //   $serie->estado_id,
            ];
        }

        return view('SerieWeb.masiva', ['csvData' => $csv]);
    }

    public function exportarMasiva()
    {
        $series = SerieModel::all();

        $filename = 'series_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($series) {
            $file = fopen('php://output', 'w');
            // Encabezado
            fputcsv($file, ['codigo', 'descripcion', 'fechainicio', 'fechafin']);

            // Contenido
            foreach ($series as $serie) {
                fputcsv($file, [
                    $serie->codigo,
                    $serie->descripcion,
                    $serie->fechainicio,
                    $serie->fechafin,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function procesarMasiva(SerieService $serieService, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt|max:10240', // 10MB máximo
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $file = $request->file('csv_file');

        $response = $serieService->cargarMasivaSeries($file->getRealPath());
        $responseData = $response->getData();
        //var_dump($responseData);
        $mensaje = $responseData->data->mensaje;
        $errors = empty($responseData->data->data->errors) ? [] : $responseData->data->data->errors;

        return view('SerieWeb.procesomasiva', compact('errors', 'mensaje'));
    }

    public function cargueMasiva()
    {
        return view('SerieWeb.cargueMasivo');
    }

    public function subir(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,csv,txt|max:2048',
        ]);

        $archivo = $request->file('archivo');
        $nombre = $archivo->getClientOriginalName();
        $peso = $archivo->getSize() / 1048576; // Peso en MB

        // Guardar archivo en storage/app/series
        $archivo->storeAs('series', $nombre);

        return back()->with('success', 'Archivo subido correctamente: ' . $nombre);
    }
}
