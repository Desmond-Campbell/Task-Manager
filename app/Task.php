<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
