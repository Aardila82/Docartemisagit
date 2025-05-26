<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SubSerieService;
use App\Services\SerieService;

use Illuminate\Support\Facades\Validator;

class SubSeriesController extends Controller
{

    protected $subSerieService;
    protected $serieService;

    public function __construct(
        SubSerieService $subSerieService,
        SerieService $serieService

    ) {
        $this->subSerieService = $subSerieService;
        $this->serieService = $serieService;
    }

    public function index()
    {
        $response = $this->subSerieService->getAll();
        //dd($response->getData());
        $subSeries = empty($response->getData()->data) ? [] : (object)$response->getData()->data->data->data;

        $response = $this->serieService->getAllActive();
        //dd($response->getData()->data);
        $series = empty($response->getData()->data->actas) ? [] : (object)$response->getData()->data->actas;

        //dd($response->getData()->data->actas);
        $estados = $this->subSerieService->getEstados();
        return view('SubSerieWeb.index', compact('subSeries', 'estados', 'series'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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
        ]);

        $data = [
            'id_codigo_serie'     => $request->id_codigo_serie,
            'codigo_subserie'     => $request->codigo_subserie,
            'descripcion'         => $request->descripcion,
            'fecha_inicio'        => $request->fecha_inicio,

            'fecha_final'         => $request->fecha_final,
            'archivo_gestion'     => $request->archivo_gestion,
            'archivo_central'     => $request->archivo_central,
            'conservacion_total'  => $request->conservacion_total,

            'eliminacion'         => $request->eliminacion,
            'microfilmacion'      => $request->microfilmacion,
            'seleccion'           => $request->seleccion,
            'procedimiento'       => $request->procedimiento,
        ];
        $response = $this->subSerieService->createSubSerie($data);

        //die($response);
        return redirect()->route('SubSerieWeb.index')
            ->with('success', $response->status() == 201 ? true : false) // true/false
            ->with('message', $response->getData()->data); // mensaje
    }


    public function procesarMasiva(SubSerieService $serieService, Request $request)
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

    public function destroy($id)
    {
        $response = $this->subSerieService->deleteSerie($id);
        $data = $response->getData(true); // Convierte JsonResponse a array

        if (!isset($data['status']) || $data['status'] !== 200) {
            return redirect()->back()->withErrors(['error' => $data['mensaje'] ?? 'No se pudo eliminar la serie.']);
        }

        return redirect()->route('SubSerieWeb.index')->with('success', $data['mensaje'] ?? 'Sub Serie eliminada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'idversion',
            'codigo',
            'descripcion',
            'fechainicio',
            'fechafin',
            'estado_id'
        ]);

        $response = $this->subSerieService->updateSerie($id, $data);

        if ($response['status'] === 200) {
            return redirect()->route('SerieWeb.index')->with('success', $response['mensaje']);
        }

        return back()->withErrors(['error' => $response['mensaje']]);
    }



    public function edit($id)
    {
        $subSerie = $this->subSerieService->getSerieById($id)->getData()->data->data;
        $estados = $this->subSerieService->getEstados();

        return view('SubSerieWeb.edit', compact('subSerie', 'estados'));
    }
}
