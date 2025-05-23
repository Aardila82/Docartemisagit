<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
//use App\Models\Serie\SerieModel;
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

    public function destroy($id)
{
    $response = $this->serieService->deleteSerie($id);
    $data = $response->getData(true); // Convierte JsonResponse a array

    if (!isset($data['status']) || $data['status'] !== 200) {
        return redirect()->back()->withErrors(['error' => $data['mensaje'] ?? 'No se pudo eliminar la serie.']);
    }

    return redirect()->route('SerieWeb.index')->with('success', $data['mensaje'] ?? 'Serie eliminada correctamente.');
}

public function update(Request $request, $id)
{
    $data = $request->only([
        'idversion', 'codigo', 'descripcion',
        'fechainicio', 'fechafin', 'estado_id'
    ]);

    $response = $this->serieService->updateSerie($id, $data);

    if ($response['status'] === 200) {
        return redirect()->route('SerieWeb.index')->with('success', $response['mensaje']);
    }

    return back()->withErrors(['error' => $response['mensaje']]);
}

// public function edit($id)
// {
//     $serie = $this->serieService->getSerieById($id)->getData();
//    // $estados = $this->estadoService->getAllEstados();

//     return view('serieWeb.edit', compact('serie', 'estados'));
// }

public function create()
{
    $this->serieService->getEstados(); // Verifica qué trae el endpoint
    // return view(...); // Puedes comentarlo temporalmente
}

public function edit($id)
{
    $serie = $this->serieService->getSerieById($id)->getData()->data->serie;
    $estados = $this->serieService->getEstados();

    return view('SerieWeb.edit', compact('serie', 'estados'));
}


}
