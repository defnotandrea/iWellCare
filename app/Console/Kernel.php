<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Send appointment reminders daily at 8 AM
        $schedule->command('appointments:send-reminders')
            ->dailyAt('08:00')
            ->description('Send appointment reminders to patients');

        // Clean up old temporary files weekly
        $schedule->command('files:cleanup')
            ->weekly()
            ->description('Clean up old temporary files');

        // Generate daily reports at 6 PM
        $schedule->command('reports:generate-daily')
            ->dailyAt('18:00')
            ->description('Generate daily healthcare reports');

        // Backup database daily at 2 AM
        $schedule->command('backup:database')
            ->dailyAt('02:00')
            ->description('Backup the database');

        // Check doctor availability status hourly
        $schedule->command('doctors:check-availability')
            ->hourly()
            ->description('Check and update doctor availability status');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
