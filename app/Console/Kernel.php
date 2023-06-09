<?php

namespace App\Console;

use App\Jobs\ProcessAllFbUsersJob;
use App\Jobs\TimeOutMessageProcessor;
use App\Jobs\TimeOutMessageSender;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('queue:work --sansdaemon --tries=3')
            ->everyMinute();

        $schedule->job(new TimeOutMessageProcessor())
            ->everyFiveMinutes();

        $schedule->job(new ProcessAllFbUsersJob())
            ->daily();
        // $schedule->command('inspire')
        //          ->hourly();
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
