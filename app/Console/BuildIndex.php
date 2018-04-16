<?php

namespace App\Console;

use App\SearchIndex;
use Carbon\Carbon;
use Mail;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\ArgvInput;

class BuildIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'buildindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build search index.';

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
        
        SearchIndex::rebuildIndex( 0, 10000 );

    }
}
