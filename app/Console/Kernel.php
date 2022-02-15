<?php

namespace App\Console;

use App\Jobs\GetPlaces;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $alphabet = range('A', 'B');
        foreach ($alphabet as $letter) {
            $schedule->command('get:place ' . $letter)->daily();
            $schedule->command('get:forecast')->daily();
            $schedule->command('get:tides')->daily();

        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
