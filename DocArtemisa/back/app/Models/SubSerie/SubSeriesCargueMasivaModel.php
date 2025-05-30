<?php

namespace App\Models\SubSerie;

use Illuminate\Database\Eloquent\Model;

class SubSeriesCargueMasivaModel extends Model
{
    // Nombre personalizado de la tabla
    protected $table = 'sub_series_cargue_masiva';

        // Desactivar timestamps si no usas created_at y updated_at
    public $timestamps = false;

    // Clave primaria personalizada
    protected $primaryKey = 'id';

    // Si no es autoincremental
    public $incrementing = true;

    // Tipo de clave primaria
    protected $keyType = 'int';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'id',
        'cantidad_registros',
        'nombre_archivo',
        'nombre_usuario',
        'peso',
        'mensaje_error',
    ];
}
