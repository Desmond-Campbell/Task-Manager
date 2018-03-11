<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchIndex extends Model
{
  protected $table = 'search_index';
  protected $fillable = [ 'project_id', 'task_id', 'data', 'keywords', 'indexed', 'user_id' ];

  public static function dirty( $id )
  {

      // The dirty method renders an index entry "dirty" or you can call it "un-indexed".

  		$project_id = Task::find( $id )->project_id ?? 0;
  		$user_id = Task::find( $id )->user_id ?? 0;
      
      $index = self::where( 'task_id', $id )->first();

      if ( empty( $index ) ) {
      
        self::create( [ 'project_id' => $project_id, 'task_id' => $id, 'data' => json_encode( [] ), 'keywords' => '', 'user_id' => $user_id ] );
      
      } else {

        self::where( 'project_id', $project_id )->where( 'task_id', $id )->where( 'indexed', 1 )->update( [ 'indexed' => 0  ] );

      }

  }

  public static function rebuildIndex($offset, $limit) {

      $tasks = Task::where('id','>','0')->skip($offset)->take($limit)->get();

      foreach ( $tasks as $task ) {
      
        self::dirty( $task->id );
        self::clean( $task->id );
      
      }

  }
  
  public static function clean( $id )
  {
      
      // The clean method indexes a record and renders the entry "clean" or you could say "indexed".

      $data = [];
      $words = '';

      $task = Task::with(['task_items', 'followups'])->find( $id );

      if ( !$task ) { return false; }

      $data['title'] = $task->title;
      $data['description'] = $task->description;
      $data['categories'] = $task->categories;
      $data['customers'] = $task->customers;
      $data['features'] = $task->features;
      $data['assignees'] = $task->assignees;
      $data['notes'] = $task->notes;

      $data['task_items'] = '';
      
      foreach ( $task->task_items as $task_item )
      {

      	$data['task_items'] .= ' ' . $task_item->title . ' ' . $task_item->description;
      
      }

      $data['followups'] = '';
      
      foreach ( $task->followups as $followup )
      {

      	$data['followups'] .= ' ' . $followup->action;
      
      }

      $words = implode( ' ', array_filter( explode( ' ', implode( ' ', array_values( $data ) ) ) ) );

      self::dirty( $id );

      self::where( 'task_id', $id )->update( [ 'keywords' => $words, 'data' => serialize( $data ), 'indexed' => 1 ] );

  }

}
