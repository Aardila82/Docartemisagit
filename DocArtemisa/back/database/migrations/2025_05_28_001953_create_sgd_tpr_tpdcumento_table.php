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
            $table->increments('ID'); // clave primaria autoincremental

            $table->integer('SGD_TPR_CODIGO')->unique(); // código único, no PK
            $table->string('SGD_TPR_DESCRIP', 255);
            $table->decimal('SGD_TPR_TERMINO', 4, 0)->nullable();
            $table->char('SGD_TPR_NUMERA', 1)->nullable(); // 'S' o 'N'
            $table->char('SGD_TPR_RADICA', 1)->nullable(); // 'S' o 'N'
            $table->integer('SGD_TPR_ESTADO')->nullable();
            $table->decimal('idversion')->nullable();

            // campo estado_id para la relación con tabla estados
            $table->unsignedBigInteger('estado_id')->nullable();

            // Definir clave foránea con tabla estados
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('set null');

            // No timestamps (created_at / updated_at) porque tu tabla no los tiene
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('SGD_TPR_TPDCUMENTO', function (Blueprint $table) {
            $table->dropForeign(['estado_id']);
        });
        Schema::dropIfExists('SGD_TPR_TPDCUMENTO');
    }
};
