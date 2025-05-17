<?php

namespace App\Services;

use App\Models\Serie\SeriesCargueMasivaModel;

class SeriesCargueMasivaService
{
    public function store(Object $data)
    {
        $archivoMasivo = SeriesCargueMasivaModel::create([
            'cantidad_registros' => $data->cantidad_registros,
            'nombre_archivo' => $data->nombre_archivo,
            'nombre_usuario' => $data->nombre_usuario,
            'peso' => $data->peso,
            'mensaje_error' => $data->mensaje_error
        ]);

        return $archivoMasivo->id;
    }

    public function getAll($perPage = 10)
{
    return SeriesCargueMasivaModel::paginate($perPage);
}


}
