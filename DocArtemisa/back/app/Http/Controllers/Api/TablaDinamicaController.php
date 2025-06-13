<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use App\Http\Controllers\Controller;

class TablaDinamicaController extends Controller
{
    public function crearTabla(Request $request)
    {
        $request->validate([
            'nombre_tabla' => 'required|string',
            'columnas' => 'required|array|min:1',
            'columnas.*.nombre' => 'required|string',
            'columnas.*.tipo' => 'required|string',
        ]);

        $tabla = $request->input('nombre_tabla');
        $columnas = $request->input('columnas');

        if (Schema::hasTable($tabla)) {
            return response()->json(['error' => "La tabla '$tabla' ya existe."], 400);
        }

        Schema::create($tabla, function (Blueprint $table) use ($columnas) {
            $table->id();

            foreach ($columnas as $col) {
                $tipo = $col['tipo'];
                $nombre = $col['nombre'];

                if (method_exists($table, $tipo)) {
                    $table->$tipo($nombre);
                } else {
                    $table->string($nombre); // tipo por defecto
                }
            }

            $table->timestamps();
        });

        return response()->json([
            'mensaje' => "Tabla '$tabla' creada exitosamente.",
            'columnas' => $columnas
        ], 201);
    }

    public function insertarLibro(Request $request)
{
    $request->validate([
        'nombre_tabla' => 'required|string',
        'datos' => 'required|array|min:1',
    ]);

    $nombreTabla = $request->input('nombre_tabla');
    $datos = $request->input('datos');

    if (!Schema::hasTable($nombreTabla)) {
        return response()->json(['error' => "La tabla '$nombreTabla' no existe."], 404);
    }

    DB::table($nombreTabla)->insert($datos);

    return response()->json([
        'mensaje' => "Registro insertado en la tabla '$nombreTabla'.",
        'datos' => $datos
    ]);
}

}
