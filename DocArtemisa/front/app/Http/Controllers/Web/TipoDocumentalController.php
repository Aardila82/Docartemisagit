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

}
