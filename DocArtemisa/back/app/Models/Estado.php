<?php

namespace App\Models;

use App\Models\Serie\SerieModel;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = ['id', 'nombre', 'descripcion'];

    // Relación con SerieModel
    public function series()
    {
        // Cambié 'estado' por 'estado_id' para coincidir con la clave foránea en la tabla 'serieversion'
        return $this->hasMany(SerieModel::class, 'estado_id', 'id');
    }
}
