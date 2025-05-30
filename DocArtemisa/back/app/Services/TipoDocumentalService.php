<?php

namespace App\Services;

use App\Models\TipoDocumental\TipoDocumental;

class TipoDocumentalService
{
    // Método para listar todos los registros
    public function index()
    {
        return TipoDocumental::all();
    }

    public function store(array $data)
{
    return \App\Models\TipoDocumental\TipoDocumental::create($data);
}

public function findById($id)
{
    return TipoDocumental::find($id);
}

public function update($id, array $data)
{
    $registro = TipoDocumental::find($id);

    if (!$registro) {
        return null;
    }

    $registro->update($data);
    return $registro;
}

public function delete($id)
{
    $registro = TipoDocumental::findOrFail($id);
    $registro->estado_id = 2; // Cambia a inactivo
    $registro->save();

    return $registro;
}




}
