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
        Schema::create('subserieversion', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->unsignedBigInteger('id_codigo_serie');
            $table->integer('codigo_subserie');

            $table->string('descripcion');
            $table->date('fecha_inicio');
            $table->date('fecha_final');

            $table->integer('archivo_gestion');
            $table->integer('archivo_central');

            // Campos tipo booleano
            $table->boolean('conservacion_total')->default(false);
            $table->boolean('eliminacion')->default(false);
            $table->boolean('microfilmacion')->default(false);
            $table->boolean('seleccion')->default(false);

            $table->text('procedimiento')->nullable();
            $table->integer('version');

            $table->unique(['id_codigo_serie', 'codigo_subserie']);

            $table->foreign('id_codigo_serie')
                  ->references('id')
                  ->on('serieversion')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subserieversion');
    }
};
