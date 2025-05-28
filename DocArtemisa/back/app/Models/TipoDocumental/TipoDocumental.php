<?php

namespace App\Models\TipoDocumental;

use Illuminate\Database\Eloquent\Model;

class TipoDocumental extends Model
{
    // Nombre exacto de la tabla en la base de datos
    protected $table = 'SGD_TPR_TPDCUMENTO';

    // Clave primaria personalizada (autoincremental)
    protected $primaryKey = 'ID';

    // Indicar que la clave primaria es autoincremental (por si acaso)
    public $incrementing = true;

    // Tipo de clave primaria (entero)
    protected $keyType = 'int';

    // Desactivar timestamps si la tabla no tiene created_at / updated_at
    public $timestamps = false;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'SGD_TPR_CODIGO',
        'SGD_TPR_DESCRIP',
        'SGD_TPR_TERMINO',
        'SGD_TPR_NUMERA',
        'SGD_TPR_RADICA',
        'SGD_TPR_ESTADO',
        'idversion',
        'estado',
    ];
}
