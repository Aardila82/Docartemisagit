<?php

namespace App\Models\Version;

use Illuminate\Database\Eloquent\Model;

class versionTrdModel extends Model
{
    //
    protected $table ='versiontrd';
    public $timestamps = false;

    protected $fillable=['estado','descripcion','fechainicio','fechafin'];
}
