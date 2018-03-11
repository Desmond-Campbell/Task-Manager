<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskFollowup extends Model
{
  protected $table = 'task_followups';
  protected $fillable = [ 'task_id', 'action', 'due_date', 'due_time', 'completed', 'user_id' ];

  public function task() {
  	return $this->belongsTo(\App\Task::class);
  }

  public function user() {
  	return $this->belongsTo(\App\User::class);
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
