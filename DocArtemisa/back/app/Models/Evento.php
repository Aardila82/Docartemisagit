<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = ['nombre', 'activo'];

    public function logEventos()
    {
        return $this->hasMany(LogEvento::class);
    }
}
