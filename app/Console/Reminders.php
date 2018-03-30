<?php

namespace App\Console;

use App\Task;
use Carbon\Carbon;
use Mail;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\ArgvInput;

class Reminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders.';

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
     * @return mixed
     */
    public function handle()
    {
        
        $argv = new ArgvInput();
        // $x   = $argv->getParameterOption('--x');
        
        // Find tasks that are due in the hour, and just email the info!

        Task::sendReminders();

    }
}
