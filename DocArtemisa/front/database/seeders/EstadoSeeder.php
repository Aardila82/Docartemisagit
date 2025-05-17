<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('estados')->insert([
            ['id' => 0, 'nombre' => 'Registrado', 'descripcion' => 'Estado inicial del registro'],
            ['id' => 1, 'nombre' => 'Activo',     'descripcion' => 'Registro en uso o habilitado'],
            ['id' => 2, 'nombre' => 'Inactivo',   'descripcion' => 'Registro no disponible o deshabilitado'],
        ]);
    }
}
