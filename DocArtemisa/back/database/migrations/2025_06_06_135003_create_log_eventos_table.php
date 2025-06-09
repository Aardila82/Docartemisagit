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
        Schema::create('log_eventos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_evento');
            $table->string('usuario'); // puedes cambiar a user_id si usas una tabla de usuarios
            $table->unsignedBigInteger('evento_id');
            $table->unsignedBigInteger('entidad_id');
            $table->text('comentario')->nullable();
            $table->json('json_data')->nullable();
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
            $table->foreign('entidad_id')->references('id')->on('entidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_eventos');
    }
};
