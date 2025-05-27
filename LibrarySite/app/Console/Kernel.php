<?php

namespace App\Console;

use App\Console\Commands\CheckDueBooks;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CheckDueBooks::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('books:check-due')->dailyAt('09:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}