<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogEvento extends Model
{
    protected $fillable = [
        'fecha_evento',
        'usuario',
        'evento_id',
        'entidad_id',
        'comentario',
        'json_data',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class);
    }
}

