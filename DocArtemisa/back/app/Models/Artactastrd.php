<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HashFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artactastrd extends Model
{
    
   //use HashFactory;
    //
    protected $table ='artactastrd';
    public $timestamps = false;

    protected $fillable=['title','descripcion','fecha','estado'];
}
