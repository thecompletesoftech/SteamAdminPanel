<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Http;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

     protected $commands = [
        Commands\Livedata::class,
];




    protected function schedule(Schedule $schedule)
    {


        // $schedule->command('livedata:steamdata')
        //      ->everyMinutes();

        $schedule->command('livedata:update')->everyMinute();


        // $schedule->call(function(){
        //     info('called every minute');
        // })->everyMinute();

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
