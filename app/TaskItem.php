<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskItem extends Model
{
  protected $table = 'task_items';
  protected $fillable = [ 'task_id', 'title', 'description', 'priority', 'completed', 'user_id' ];

  public function task() {
  	return $this->belongsTo(\App\Task::class);
  }

  public function user() {
  	return $this->belongsTo(\App\User::class);
  }

  public static function calculateCompletion( $task_id ) {

    $total = $total_completed = 0;
    $task_items = TaskItem::where('task_id', $task_id)->get();

    foreach ( $task_items as $task_item ) {

      $task_id = $task_item->task_id;

      $weight = 100 - ( ( (float) $task_item->priority ) ?? 50 );
      $total += $weight;

      if ( $task_item->completed ) $total_completed += $weight;

    }

    if ( !$total ) return 0;

    $completion = (int) ( 100 * $total_completed / $total );

    Task::where( 'id', $task_id )->update( [ 'completion' => $completion ] );

    return $completion;

  }

  protected static function boot()
  {
    parent::boot();
    static::saved(
      function( $object )
      {          
        SearchIndex::dirty( $object->task_id );
        return true;
      }
    );
    static::deleted(
      function( $object )
      {
        SearchIndex::dirty( $object->task_id );
        return true;
      }
    );
  }

}
