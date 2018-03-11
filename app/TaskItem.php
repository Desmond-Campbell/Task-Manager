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

}