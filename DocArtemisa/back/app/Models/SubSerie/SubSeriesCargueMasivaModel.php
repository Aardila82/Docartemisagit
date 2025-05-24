<?php

namespace App\Models\SubSerie;

use Illuminate\Database\Eloquent\Model;

class SubSeriesCargueMasivaModel extends Model
{
    // Nombre personalizado de la tabla
    protected $table = 'sub_series_cargue_masiva';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'cantidad_registros',
        'nombre_archivo',
        'nombre_usuario',
        'peso',
        'mensaje_error',
    ];
}
