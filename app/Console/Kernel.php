<?php

namespace App\Console;
use App\Console\Commands\BackupDatabase;
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
    protected $commands = [
        BackupDatabase::class, // Register your custom command
    ];

    protected function schedule(Schedule $schedule)
    {
        
        //  $schedule->command('/usr/local/bin/php /home/u929332160/public_html/artisan mail:cron')->everyMinute();
        
        // $schedule->command('mail:cron')->everyMinute();
      $schedule->command('mail:cron')
        ->everyFiveMinutes()
        ->when(function () {
        return now()->minute % 30 == 0; // Execute only at 0 and 30 minutes past the hour
    });

    // For Createing Patient_login_id
    $schedule->command('patient_login_id:generate')
        ->everyFiveMinutes()
        ->when(function () {
        return now()->minute % 30 == 0; // Execute only at 0 and 30 minutes past the hour
    });

    // For Backup Database
    $schedule->command('backup:database')->daily();  // Or use ->dailyAt('02:00') for specific time
    
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
