<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $command = [
        Command\Pengingat::class,
        Command\SeverancePay::class
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('Pengingat:cron')
            ->dailyAt('07:00');
        // $schedule->command('severance:cron')
        //     ->everyMinute();
        $schedule->command('sisa:cuti')
            ->daily();
        $schedule->command('resign:cron')
            ->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
