<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Task;
use App\TaskItem;

class TaskController extends Controller
{
  public function __construct(){

  	$this->middleWare('auth');

  }

 	public function edit( Request $R ) {

 		$task_id = $R->route('id', 0);
 		$user_id = get_user_id();
 
 		return view('tasks.edit', compact('task_id'));

 	}

 	public function getTask( Request $R ) {

 		$id = $R->route('id', 0);
 		$user_id = get_user_id();
 		$project_id = get_project_id();

 		$task = Task::where('user_id', $user_id)->where('project_id', $project_id)->with('task_items')->find( $id );

 		return response()->json( [ 'task' => $task ] );

 	}

 	public function updateTask( Request $R ) {

 		$id = $R->route('id', 0);
 		$project_id = get_project_id();
 		$user_id = get_user_id();

 		$title = $R->input('title');
 		$description = $R->input('description');
 		$priority = (float) $R->input('priority');
 		$start_date = $R->input('start_date');
 		$start_time = $R->input('start_time');
 		$due_date = $R->input('due_date');
 		$due_time = $R->input('due_time');
 		$customers = $R->input('customers');
 		$categories = $R->input('categories');
 		$features = $R->input('features');
 		$assignees = $R->input('assignees');
 		$task_items = $R->input('task_items');

 		$task = null;

 		if ( $id ) {

 			$task = Task::where('user_id', $user_id)->where('project_id', $project_id)->with('task_items')->find( $id );

 			if ( !$task ) $task = null;

 		}

 		$task_data = [];

 		$data['title'] = $title;
 		$data['description'] = $description;
 		$data['priority'] = $priority;
 		$data['start_date'] = Carbon::parse( $start_date )->toDateString();
 		$data['start_time'] = Carbon::parse( $start_time )->toTimeString();
 		$data['due_date'] = Carbon::parse( $due_date )->toDateString();
 		$data['due_time'] = Carbon::parse( $due_time )->toTimeString();
 		$data['customers'] = $customers;
 		$data['categories'] = $categories;
 		$data['features'] = $features;
 		$data['assignees'] = $assignees;

 		$priority_list = [];
		
		foreach ( $task_items as $key => $row ){
			$priority_list[$key] = $row['priority'];
		}
 		
 		array_multisort( $priority_list, SORT_ASC, $task_items );

 		if ( $task ) {

 			$task->update( $data );
 			$task->save();

 			foreach ( $task_items as $task_item ) {

 				$task_item_record = TaskItem::where('user_id', $user_id)->find( $task_item['id'] );

 				if ( !$task_item_record ) {

	 				$task_item['task_id'] = $task->id;
	 				$task_item['user_id'] = $user_id;

	 				TaskItem::create( $task_item );

	 			} else {

	 				if ( !( $task_item['deleted'] ?? false ) ) {

	 					$task_item_record->update( $task_item );
	 					$task_item_record->save();

	 				} else {

	 					$task_item_record->delete();

	 				}

	 			}
 				
 			}

 		} else {

 			$data['user_id'] = $user_id;
 			$data['project_id'] = $project_id;
 			$task = Task::create( $data );

 			foreach ( $task_items as $task_item ) {

 				$task_item['task_id'] = $task->id;
 				$task_item['user_id'] = $user_id;

 				TaskItem::create( $task_item );

 			}

 		}

 	}

}
