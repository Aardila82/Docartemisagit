<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CrearTablaDinamica extends Command
{
    protected $signature = 'crear:tabla-dinamica';
    protected $description = 'Crea una tabla dinámica desde cero con columnas definidas por el usuario';

    public function handle()
    {
        $tableName = $this->ask('¿Cuál será el nombre de la nueva tabla?');

        $columnas = [
            ['nombre' => 'titulo', 'tipo' => 'string'],
            ['nombre' => 'descripcion', 'tipo' => 'text'],
            ['nombre' => 'activo', 'tipo' => 'boolean'],
            ['nombre' => 'fecha_lanzamiento', 'tipo' => 'date'],
        ];

        if (Schema::hasTable($tableName)) {
            $this->error("La tabla '$tableName' ya existe.");
            return;
        }

        Schema::create($tableName, function (Blueprint $table) use ($columnas) {
            $table->id();

            foreach ($columnas as $col) {
                $tipo = $col['tipo'];
                $nombre = $col['nombre'];

                if (method_exists($table, $tipo)) {
                    $table->$tipo($nombre);
                } else {
                    $table->string($nombre); // tipo por defecto
                }
            }

            $table->timestamps();
        });

        $this->info("Tabla '$tableName' creada exitosamente.");
    }
}
