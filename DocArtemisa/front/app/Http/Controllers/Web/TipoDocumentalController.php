<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\TipoDocumentalService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TipoDocumentalController extends Controller
{
    protected TipoDocumentalService $service;

    public function __construct(TipoDocumentalService $service)
    {
        $this->service = $service;
    }

    public function index(): View
{
    $tiposDocumentales = $this->service->getAll();

    // Tabla de traducción de estados
    $estados = [
        0 => 'Activo',
        1 => 'Inactivo',
        2 => 'Archivado',
    ];

    return view('tipo_documental.index', compact('tiposDocumentales', 'estados'));
}


public function store(Request $request): RedirectResponse
{
    // Validar los campos que vienen del formulario
    $validated = $request->validate([
        'SGD_TPR_CODIGO' => 'required|string',
        'SGD_TPR_DESCRIP' => 'required|string',
        'SGD_TPR_TERMINO' => 'required|string',
        'SGD_TPR_NUMERA' => 'required|string',
        'SGD_TPR_RADICA' => 'required|string',
        'SGD_TPR_ESTADO' => 'required|string',
        'idversion'       => 'required|string',
        'estado_id'       => 'required|integer',
    ]);

    // Enviar al servicio para que haga el POST a la API externa
    $response = $this->service->create($validated);

    // Verificar si hubo error
    if (isset($response['error'])) {
        return redirect()->route('tipos-documentales.index')->with('error', $response['error']);
    }

    // Redirigir con mensaje de éxito
    return redirect()->route('tipos-documentales.index')->with('success', 'Tipo documental creado correctamente.');
}

public function edit($id)
{
    $tipoDocumental = $this->service->findById($id);

    if (!$tipoDocumental) {
        return redirect()->route('tipos-documentales.index')->with('error', 'Tipo Documental no encontrado');
    }

    $estados = [
        1 => 'Activo',
        2 => 'Inactivo',
        3 => 'Archivado'
    ];

    // **Fíjate que aquí la variable se llama $tipoDocumental**
    return view('tipo_documental.edit', compact('tipoDocumental', 'estados'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'SGD_TPR_CODIGO' => 'required|string',
        'SGD_TPR_DESCRIP' => 'required|string',
        'SGD_TPR_TERMINO' => 'required|integer',
        'SGD_TPR_NUMERA' => 'required|string',
        'SGD_TPR_RADICA' => 'required|string',
        'estado_id' => 'required|integer',
    ]);

    $response = $this->service->update($id, $validated);

    if (!$response) {
        return redirect()->route('tipos-documentales.index')->with('error', 'Error al actualizar el tipo documental');
    }

    return redirect()->route('tipos-documentales.index')->with('success', 'Tipo documental actualizado correctamente');
}

public function cambiarEstado($id): RedirectResponse
{
    $tipo = $this->service->findById($id);

    if (!$tipo) {
        return redirect()->route('tipos-documentales.index')->with('error', 'Tipo Documental no encontrado');
    }

    $nuevoEstado = $tipo['estado_id'] == 1 ? 2 : 1; // Alterna entre activo (1) e inactivo (2)

    $response = $this->service->update($id, ['estado_id' => $nuevoEstado]);

    if (isset($response['error'])) {
        return redirect()->route('tipos-documentales.index')->with('error', $response['error']);
    }

    return redirect()->route('tipos-documentales.index')->with('success', 'Estado actualizado correctamente.');
}



}
