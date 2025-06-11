<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EntidadSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('entidades')->insert([
            ['nombre' => 'Serie', 'activo' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nombre' => 'SubSerie', 'activo' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nombre' => 'Tipo Documental', 'activo' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
