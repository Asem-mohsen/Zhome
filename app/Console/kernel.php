<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\Admin\DeleteExpiredSales;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        Commands\Admin\DeleteExpiredSales::class,
    ];


    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sale:delete-expired')->daily();
        /*$schedule->command('users:update')->everyMinute();
        $schedule->command('servers:update')->everyMinute();*/
    }


    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}