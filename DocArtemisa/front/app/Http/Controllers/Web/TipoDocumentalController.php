<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TipoDocumentalController extends Controller
{
    // Mostrar el formulario
    public function index()
{
    return view('TipoDocumental.index');
}

public function edit($codigo)
    {
        // Datos quemados
        $tipoDocumental = [
            'codigo' => $codigo,
            'descripcion' => 'Actas de reunión',
            'termino' => 12,
            'numeracion' => 'Sí',
            'radicacion' => 'No',
            'estado' => 'registrado',
        ];

        return view('TipoDocumental.edit', compact('tipoDocumental'));
    }

}
