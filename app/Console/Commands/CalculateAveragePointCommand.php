<?php

namespace App\Console\Commands;

use App\Jobs\CalculateAveragePoint;
use Illuminate\Console\Command;

class CalculateAveragePointCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:average_point';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate average point for students who have registered all subjects';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dispatch(new CalculateAveragePoint());
        $this->info('Average points calculated and updated for eligible students.');
    }
}
