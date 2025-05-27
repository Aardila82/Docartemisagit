<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubSeriesCargueMasivaController extends Controller
{
    public function index()
    {
        // Aquí puedes pasar datos reales o quemados si quieres
        return view('SubSerieWeb.seriesCargueMasiva');
    }

    public function edit($codigo)
{
    // Datos quemados para prueba
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
