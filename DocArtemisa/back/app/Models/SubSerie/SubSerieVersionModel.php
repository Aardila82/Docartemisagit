<?php

namespace App\Models\SubSerie;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use  App\Models\Serie\SerieModel;

class SubSerieVersionModel extends Model
{
    // Nombre de la tabla si no sigue la convención plural
    protected $table = 'subserieversion';

    // Desactivar timestamps si no usas created_at y updated_at
    public $timestamps = false;

    // Clave primaria personalizada
    protected $primaryKey = 'id';

    // Si no es autoincremental
    public $incrementing = true;

    // Tipo de clave primaria
    protected $keyType = 'int';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id',
        'id_codigo_serie',
        'codigo_subserie',
        'descripcion',
        'fecha_inicio',
        'fecha_final',
        'archivo_gestion',
        'archivo_central',
        'conservacion_total',
        'eliminacion',
        'microfilmacion',
        'seleccion',
        'procedimiento',
        'version',
    ];

    /**
     * Relación con la serieversion (muchas subseries pertenecen a una serie)
     */
    public function serieversion(): BelongsTo
    {
        return $this->belongsTo(SerieModel::class, 'id_codigo_serie', 'id');
    }
}
