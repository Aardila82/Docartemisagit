<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
{
    Schema::create('SGD_TPR_TPDCUMENTO', function (Blueprint $table) {
        $table->increments('ID'); // ID como clave primaria auto incremental

        $table->integer('SGD_TPR_CODIGO')->unique(); // Código lógico, único pero no clave primaria
        $table->string('SGD_TPR_DESCRIP', 255);
        $table->decimal('SGD_TPR_TERMINO', 4, 0)->nullable();
        $table->char('SGD_TPR_NUMERA', 1)->nullable(); // S o N
        $table->char('SGD_TPR_RADICA', 1)->nullable(); // S o N
        $table->integer('SGD_TPR_ESTADO')->nullable();
        $table->decimal('idversion')->nullable();
        $table->enum('estado', ['registrado', 'inactivo'])->nullable();


    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgd_tpr_tpdcumento');
    }
};
