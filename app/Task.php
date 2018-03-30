<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Mail;

class Task extends Model
{
  
  protected $table = 'tasks';
  protected $fillable = [ 'project_id', 'title', 'description', 'priority', 'completion', 'start_date', 'start_time', 'due_date', 'due_time', 'assignees', 'customers', 'categories', 'features', 'status', 'user_id' ];

  public function task_items() {
  	return $this->hasMany(\App\TaskItem::class);
  }

  public function followups() {
  	return $this->hasMany(\App\TaskFollowup::class);
  }

  public function user() {
  	return $this->belongsTo(\App\User::class);
  }

  public static function calculateCompletion( $tasks ) {

    foreach ( $tasks as $task ) {

      $task->completion = TaskItem::calculateCompletion( $task->id );

    }

    return $tasks;

  }

  public static function updateSchedule( $task_id ) {

    $task = self::find( $task_id );

    if ( !$task ) return;

    $start_date = $task->start_date;
    $start_time = $task->start_time;
    $task->start_date_full = "$start_date $start_time";

    $due_date = $task->due_date;
    $due_time = $task->due_time;
    $task->due_date_full = "$due_date $due_time";

    $task->save();

  }

  public static function sendReminders( $args = [] ) {

    $start_time = Carbon::now()->format("Y-m-d H:00:00");
    $end_time = Carbon::now()->format("Y-m-d H:59:59");

    $date_range = [ $start_time, $end_time ];

    $tasks_start = Task::where('completed', 0)->whereBetween( 'start_date_full', $date_range )->get();
    $tasks_due = Task::where('completed', 0)->whereBetween( 'due_date_full', $date_range )->get();

    $task_list_start = [];
    $task_list_due = [];

    foreach ( $tasks_start as $task ) {

        $task_list_start[] = '<strong><a href="' . env('APP_URL') . '/edit/' . $task->id . '">' . $task->title . '</a></strong> ' . ___( 'starts' ) . ' @ ' . format_date( $task->start_time, 'H:i a' );

    }

    foreach ( $tasks_due as $task ) {

        $task_list_due[] = '<strong><a href="' . env('APP_URL') . '/edit/' . $task->id . '">' . $task->title . '</a></strong> ' . ___( 'is due' ) . ' @ ' . format_date( $task->start_time, 'H:i a' );

    }

    if ( count( $task_list_start ) || count( $task_list_due ) ) {

      $subject = ___( 'Reminders' ) . ' - ' . $start_time;
      $data = [];
      $data['task_list_start'] = implode( '<br />', $task_list_start ) . '<br /><br />' . "\n";
      $data['task_list_due'] = implode( '<br />', $task_list_due ) . '<br /><br />' . "\n";

      Mail::send( [], [], function ($message) use ( $subject, $data ) {
      
          $body = '<strong>' . strtoupper( ___( 'Starting About Now' ) ) . '</strong><br /><br />';
          $body .= $data['task_list_start'];
          $body .= '<strong>' . strtoupper( ___( 'Due About Now' ) ) . '</strong><br /><br />';
          $body .= $data['task_list_due'];

          $message->to( 'docampbell@gmail.com' );
          $message->subject( $subject );
          $message->from( 'docampbell@gmail.com' );
          $message->setBody( $body, 'text/html' );

      });

    } else {

      if ( $args['force_send'] ?? false ) {

        $subject = ___( 'Reminders' ) . ' - ' . $start_time;
        $data = [];
        $data['task_list_start'] = implode( '<br />', [ ___('Nothing starting this period.') ] ) . '<br /><br />' . "\n";
        $data['task_list_due'] = implode( '<br />', [ ___('Nothing due this period.') ] ) . '<br /><br />' . "\n";

        Mail::send( [], [], function ($message) use ( $subject, $data ) {
        
            $body = '<strong>' . strtoupper( ___( 'Starting About Now' ) ) . '</strong><br /><br />';
            $body .= $data['task_list_start'];
            $body .= '<strong>' . strtoupper( ___( 'Due About Now' ) ) . '</strong><br /><br />';
            $body .= $data['task_list_due'];

            $message->to( 'docampbell@gmail.com' );
            $message->subject( $subject );
            $message->from( 'docampbell@gmail.com' );
            $message->setBody( $body, 'text/html' );

        });

      }
    }

  }

  protected static function boot()
  {
    parent::boot();
    static::saved(
      function( $object )
      {          
        SearchIndex::dirty( $object->id );
        return true;
      }
    );
    static::deleted(
      function( $object )
      {
        SearchIndex::dirty( $object->id );
        return true;
      }
    );
  }

}
