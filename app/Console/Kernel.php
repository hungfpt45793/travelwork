<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\PostsCron::class,
        Commands\VoucherCron::class,
        Commands\PodcastCron::class,
        Commands\NotificationPostCron::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('posts:cron')
                  ->everyMinute();
         $schedule->command('voucher:cron')
                  ->everyMinute();
         $schedule->command('podcast:cron')
            ->dailyAt('11:00');
         $schedule->command('notification:cron')
            ->monthlyOn(1, '00:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
