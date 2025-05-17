<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
    {
        Schema::create('series_cargue_masiva', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cantidad_registros');
            $table->string('nombre_archivo');
            $table->string('nombre_usuario');
            $table->unsignedBigInteger('peso'); 
            $table->string('mensaje_error'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series_cargue_masiva');
    }
};
