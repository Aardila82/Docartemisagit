<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    protected $table = 'entidades';
    protected $fillable = ['nombre', 'activo'];

    public function logEventos()
    {
        return $this->hasMany(LogEvento::class);
    }
}
