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
}
