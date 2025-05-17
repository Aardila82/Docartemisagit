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
        Schema::create('versiontrd', function (Blueprint $table) {
            $table->id();
            $table->text('estado');
            $table->text('descripcion');
            $table->datetime('fechainicio');
            $table->datetime('fechafin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('versiontrd');
    }
};
