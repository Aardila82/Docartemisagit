<?php

namespace App\Models\TipoDocumental;

use Illuminate\Database\Eloquent\Model;
use App\Models\EstadoModel;

class TipoDocumental extends Model
{
    protected $table = 'SGD_TPR_TPDCUMENTO';

    protected $primaryKey = 'ID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'SGD_TPR_CODIGO',
        'SGD_TPR_DESCRIP',
        'SGD_TPR_TERMINO',
        'SGD_TPR_NUMERA',
        'SGD_TPR_RADICA',
        'SGD_TPR_ESTADO',
        'idversion',
        'estado_id', // ⚠️ Este campo debe existir en tu migración
    ];

    /**
     * Relación: TipoDocumental pertenece a un Estado
     */
    public function estado()
    {
        return $this->belongsTo(EstadoModel::class, 'estado_id', 'id');
    }
}
