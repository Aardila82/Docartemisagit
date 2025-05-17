<?php

namespace App\Models\Serie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeriesCargueMasivaModel extends Model
{
    use HasFactory;

    protected $table = 'series_cargue_masiva';

    protected $fillable = [
        'cantidad_registros',
        'nombre_archivo',
        'nombre_usuario',
        'peso',
        'mensaje_error',
    ];
}