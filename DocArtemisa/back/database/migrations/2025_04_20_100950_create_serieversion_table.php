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
    Schema::create('serieversion', function (Blueprint $table) {
        $table->id();
        $table->integer('idversion')->nullable();
        $table->integer('codigo');
        $table->text('descripcion');
        $table->date('fechainicio');
        $table->date('fechafin');

        // Relación con la tabla estados
        $table->unsignedBigInteger('estado_id')->default(0);
        $table->foreign('estado_id')->references('id')->on('estados')->onDelete('no action');  // Usamos no action en vez de restrict

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serieversion');
    }
};
