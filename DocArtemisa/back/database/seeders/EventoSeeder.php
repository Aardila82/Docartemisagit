<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('eventos')->insert([
            ['nombre' => 'Creación', 'activo' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nombre' => 'Actualización', 'activo' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nombre' => 'Eliminación', 'activo' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
