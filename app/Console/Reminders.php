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

        $start_time = Carbon::now()->format("Y-m-d H:00:00");
        $end_time = Carbon::now()->format("Y-m-d H:59:59");

        $date_range = [ $start_time, $end_time ];

        $tasks_start = Task::where('completed', 0)->whereBetween( 'start_date_full', $date_range )->get();
        $tasks_due = Task::where('completed', 0)->whereBetween( 'due_date_full', $date_range )->get();

        $task_list_start = [];
        $task_list_due = [];

        foreach ( $tasks_start as $task ) {

            $task_list_start[] = '<strong>' . $task->title . '</strong> ' . ___( 'starts' ) . ' @ ' . format_date( $task->start_time, 'H:i a' );

        }

        foreach ( $tasks_due as $task ) {

            $task_list_due[] = '<strong>' . $task->title . '</strong> ' . ___( 'is due' ) . ' @ ' . format_date( $task->start_time, 'H:i a' );

        }

        if ( count( $task_list_start ) || count( $task_list_due ) ) {

            $subject = ___( 'Reminders' ) . ' - ' . $start_time;
            $body = '';
            $body .= '<strong>' . strtoupper( ___( 'Starting About Now' ) ) . '</strong><br /><br />' . "\n";
            $body .= implode( '<br />', $task_list_start ) . '<br /><br />' . "\n";
            $body .= '<strong>' . strtoupper( ___( 'Due About Now' ) ) . '</strong><br /><br />' . "\n";
            $body .= implode( '<br />', $task_list_due ) . '<br /><br />' . "\n";

            Mail::raw( $body, function ($message) use ( $subject ) {
            
                $message->to( 'docampbell@gmail.com' );
                $message->subject( $subject );
                $message->from( 'docampbell@gmail.com' );

            });

        } else {

            $subject = ___( 'Reminders' ) . ' - ' . $start_time;
            $body = '';
            $body .= '<p>Nothing now.</p>';

            Mail::raw( $body, function ($message) use ( $subject ) {
            
                $message->to( 'docampbell@gmail.com' );
                $message->subject( $subject );
                $message->from( 'docampbell@gmail.com' );

            });            
        }

    }
}
