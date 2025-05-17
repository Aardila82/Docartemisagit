<?php

namespace App\Models\Serie;

use Illuminate\Database\Eloquent\Model;
use App\Models\Estado;

class SerieModel extends Model
{
    protected $table = 'serieversion';  // Nombre de la tabla
    public $timestamps = false;         // No usar timestamps
    protected $fillable = ['idversion', 'codigo', 'estado_id', 'descripcion', 'fechainicio', 'fechafin']; // Corregido 'estado' a 'estado_id'

    // Relación con el modelo Estado
    public function estado()
    {
        // Definimos que esta serie pertenece a un estado, usando 'estado_id' como clave foránea
        return $this->belongsTo(Estado::class, 'estado_id', 'id');
    }
}
