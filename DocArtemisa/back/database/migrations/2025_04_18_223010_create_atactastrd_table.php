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
        Schema::create('actastrd', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('descripcion');
            $table->datetime('fecha');
            $table->enum('estado',['registrado','Activo','Inactivo']);

        });
    }



    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actastrd');
    }
};
