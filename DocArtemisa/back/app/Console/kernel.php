<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Registra los comandos personalizados.
     */
    protected $commands = [
        \App\Console\Commands\CrearTablaDinamica::class,
    ];

    /**
     * Define la programación de tareas.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Aquí puedes programar comandos recurrentes si los necesitas
    }

    /**
     * Carga los comandos de la carpeta Commands.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
