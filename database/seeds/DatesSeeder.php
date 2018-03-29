<?php

use Illuminate\Database\Seeder;
use App\Task;

class DatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      	
      $tasks = Task::all();

      foreach ( $tasks as $task ) {

      	Task::updateSchedule( $task->id );

      }
    
    }
}
