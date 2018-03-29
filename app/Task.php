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

    // if ( !is_array( $tasks ) ) return [];

    foreach ( $tasks as $task ) {

      $task->completion = TaskItem::calculateCompletion( $task->task_items ?? [] );

    }

    return $tasks;

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
