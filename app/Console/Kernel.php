<?php

namespace App\Console;

use App\Console\Commands\CalculateAveragePointCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        CalculateAveragePointCommand::class,
        ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job('command:average_point')->everyMinute();
        $schedule->job('update:student_status')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        $this->app->singleton('command:average_point', function ($app) {
            return new \App\Console\Commands\CalculateAveragePointCommand();
        });
        $this->app->singleton('update:student_status', function ($app) {
            return new \App\Console\Commands\UpdateStudentStatusCommand();
        });

        require base_path('routes/console.php');
    }
}
