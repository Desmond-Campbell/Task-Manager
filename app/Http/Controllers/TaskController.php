<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Task;
use App\TaskItem;
use App\TaskFollowup;
use App\SearchIndex;

class TaskController extends Controller
{
  public function __construct(){

  	$this->middleWare('auth');

  }

 	public function edit( Request $R ) {

 		$task_id = $R->route('id', 0);
 		$user_id = get_user_id();

 		$title = Task::find( $task_id )->title ?? '';
 
 		return view('tasks.edit', compact('task_id', 'title'));

 	}

 	public function search( Request $R )
  {

    $query = $R->route('query');

    $response = SearchIndex::whereRaw(
        "MATCH(keywords) AGAINST(? IN BOOLEAN MODE)", 
        [ '*' . $query . '*' ]
    )->take( 50 )->get();

    $results = [];

    foreach ( $response as $r ) {

      $t = Task::find( $r->task_id );

      if ( $t ) {
          $results[$t->title . $t->id] = $t;
      }

    }

    ksort( $results );

    return response()->json( [ 'tasks' => array_values( $results ), 'mode' => 'search', 'query' => $query ] );
  
  }

  public function searchResults( Request $R )
  {

    $query = $R->route('query');

    return view('tasks.search', compact('query'));
  
  }

 	public function getTask( Request $R ) {

 		$id = $R->route('id', 0);
 		$user_id = get_user_id();
 		$project_id = get_project_id();

 		$task = Task::where('user_id', $user_id)->where('project_id', $project_id)->with([ 'task_items' => function ( $q ) { $q->orderBy('priority', 'asc'); }, 'followups' => function ( $q ) { $q->orderBy( 'due_date', 'asc' ); $q->orderBy( 'due_time', 'asc' ); }])->find( $id );

 		if ( $task ) {

 			$task_items_complete = [];
 			$task_items_incomplete = [];

 			foreach ( $task->task_items as $item ) {

 				if ( $item->completed ) {

 					$task_items_complete[] = $item;

 				} else {

 					$task_items_incomplete[] = $item;

 				}

 			}

 			$task->task_items_incomplete = $task_items_incomplete;
 			$task->task_items_complete = $task_items_complete;

 		}

 		return response()->json( [ 'task' => $task ] );

 	}

 	public function saveTaskNotes( Request $R ) {

 		$id = $R->route('id', 0);
 		$project_id = get_project_id();
 		$user_id = get_user_id();

 		$notes = $R->input('notes');

 		$task = null;

 		if ( $id ) {

 			$task = Task::where('user_id', $user_id)->where('project_id', $project_id)->find( $id );

 			if ( !$task ) $task = null;

 		}

 		if ( $task ) {

 			$task->notes = $notes;
 			$task->save();

 		}

 	}
 	
 	public function updateTask( Request $R ) {

 		$id = $R->route('id', 0);
 		$project_id = get_project_id();
 		$user_id = get_user_id();

 		$title = $R->input('title');
 		$description = $R->input('description');
 		$priority = (float) $R->input('priority', 50);
 		$start_date = $R->input('start_date');
 		$start_time = $R->input('start_time');
 		$due_date = $R->input('due_date');
 		$due_time = $R->input('due_time');
 		$customers = $R->input('customers');
 		$categories = $R->input('categories');
 		$features = $R->input('features');
 		$assignees = $R->input('assignees');
 		$task_items = $R->input('task_items');
 		$followups = $R->input('followups');

 		$task = null;

 		if ( $id ) {

 			$task = Task::where('user_id', $user_id)->where('project_id', $project_id)->with('task_items', 'followups')->find( $id );

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
			$priority_list[$key] = $row['priority'] ?? rand ( 40, 60 );
		}
 		
 		array_multisort( $priority_list, SORT_ASC, $task_items );

 		if ( $task ) {

 			$task->update( $data );
 			$task->save();

 			foreach ( $task_items as $task_item ) {

 				$task_item_record = TaskItem::where('user_id', $user_id)->find( $task_item['id'] ?? 0 );

 				if ( !$task_item_record ) {

	 				$task_item['task_id'] = $task->id;
	 				$task_item['user_id'] = $user_id;
	 				$task_item['priority'] = $task_item['priority'] ?? 50;

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

 			foreach ( $followups as $followup ) {

 				$followup['due_date'] = Carbon::parse( $followup['due_date'] )->toDateString();
 				$followup['due_time'] = Carbon::parse( $followup['due_time'] ?? '12:00' )->toTimeString();

 				$followup_record = TaskFollowup::where('user_id', $user_id)->find( $followup['id'] ?? 0 );

 				if ( !$followup_record ) {

	 				$followup['task_id'] = $task->id;
	 				$followup['user_id'] = $user_id;

	 				TaskFollowup::create( $followup );

	 			} else {

	 				if ( !( $followup['deleted'] ?? false ) ) {

	 					$followup_record->update( $followup );
	 					$followup_record->save();

	 				} else {

	 					$followup_record->delete();

	 				}

	 			}
 				
 			}

 		} else {

 			$data['user_id'] = $user_id;
 			$data['project_id'] = $project_id;
 			$task = Task::create( $data );
 			$id = $task->id;

 			foreach ( $task_items as $task_item ) {

 				$task_item['task_id'] = $task->id;
 				$task_item['user_id'] = $user_id;

 				TaskItem::create( $task_item );

 			}

 			foreach ( $followups as $followup ) {

 				$followup['task_id'] = $task->id;
 				$followup['user_id'] = $user_id;
				$followup['due_date'] = Carbon::parse( $followup['due_date'] )->toDateString();
 				$followup['due_time'] = Carbon::parse( $followup['due_time'] ?? '12:00' )->toTimeString();

 				TaskFollowup::create( $followup );

 			}

 		}

 		$task = Task::with( 'task_items', 'followups' )->find( $id );

 		return response()->json( [ 'task' => $task ] );

 	}

 	public function deleteTask( Request $R ) {

 		$id = $R->route('id', 0);
 		$project_id = get_project_id();
 		$user_id = get_user_id();

 		if ( $id ) {

 			$task = Task::where('user_id', $user_id)->where('project_id', $project_id)->with('task_items', 'followups')->find( $id )->delete();

 		} else {

 			return response()->json( [ 'errors' => ___('Not found.') ] );

 		}

 	}

 	public function action( Request $R ) {

 		$id = $R->route('id', 0);
 		$project_id = get_project_id();
 		$user_id = get_user_id();

 		if ( $id ) {

 			$task = Task::where('user_id', $user_id)->where('project_id', $project_id)->with('task_items', 'followups')->find( $id );

 			if ( $task ) {

 				switch ( $R->input('action') ) {

 					case 'enlist':

 						$task->working = 1;
 						$task->save();

 					break;

 					case 'delist':

 						$task->working = 0;
 						$task->save();

 					break;

 					case 'complete':

 						$task->completed = 1;
 						$task->save();

 					break;

 					case 'incomplete':

 						$task->completed = 0;
 						$task->save();

 					break;

 					case 'cancel':

 						$task->delete();

 					break;

 					case 'reschedule':

 						$task_due = explode( ' ', $R->input('due') );
 							$task_due_date = ( $task_due[0] ?? '' ) ?? 'tomorrow';
 							$task_due_time = ( $task_due[1] ?? '' ) ?? '13:00:00';
 						$task->due_date = Carbon::parse( $task_due_date )->toDateString();
 						$task->due_time = Carbon::parse( $task_due_time )->toTimeString();

 						$task->save();

 					break;

 					case 'followup':

 						$followup = [];
 						$followup['user_id'] = get_user_id();
 						$followup['task_id'] = $id;
 						$followup['action'] = $R->input('followup_action');

 						$followup_due = explode( ' ', $R->input('due') );
 							$followup_due_date = ( $followup_due[0] ?? '' ) ?? 'tomorrow';
 							$followup_due_time = ( $followup_due[1] ?? '' ) ?? '13:00:00';
 						$followup['due_date'] = Carbon::parse( $followup_due_date )->toDateString();
 						$followup['due_time'] = Carbon::parse( $followup_due_time )->toTimeString();
 						
 						TaskFollowup::create( $followup );

 					break;

 					case 'reassign':

 						$task->assignees = $R->input('assignees');
 						$task->save();

 					break;

 					case 'reprioritise':

 						$task->priority = $R->input('priority');
 						$task->save();

 					break;

 					case 'complete_task_item':

 						$task_item_record = TaskItem::where('user_id', $user_id)->find($R->input('task_item')['id'] ?? 0);

 						if ( $task_item_record ) {
	 					
	 						$task_item_record->completed = 1;
	 						$task_item_record->save();

	 					}

 					break;

 					case 'incomplete_task_item':

 						$task_item_record = TaskItem::where('user_id', $user_id)->find($R->input('task_item')['id'] ?? 0);

 						if ( $task_item_record ) {
	 					
	 						$task_item_record->completed = 0;
	 						$task_item_record->save();

	 					}

 					break;

 					case 'complete_followup':

 						$followup_record = TaskFollowup::where('user_id', $user_id)->find($R->input('followup')['id'] ?? 0);

						if ( $followup_record ) {
 		
 							$followup_record->completed = 1;
 							$followup_record->save();

 						}

 					break;

					case 'cancel_followup':

 						$followup_record = TaskFollowup::where('user_id', $user_id)->find($R->input('followup')['id'] ?? 0);

						if ( $followup_record ) {
 		
 							$followup_record->delete();

 						}

 					break;

					case 'reschedule_followup':

 						$followup_record = TaskFollowup::where('user_id', $user_id)->find($R->input('followup')['id'] ?? 0);

						if ( $followup_record ) {
 		
 							$followup_due = explode( ' ', $R->input('due') );
 							$followup_due_date = ( $followup_due[0] ?? '' ) ?? 'tomorrow';
 							$followup_due_time = ( $followup_due[1] ?? '' ) ?? '13:00:00';
	 						$followup_record->due_date = Carbon::parse( $followup_due_date )->toDateString();
	 						$followup_record->due_time = Carbon::parse( $followup_due_time )->toTimeString();

	 						$followup_record->save();

 						}

 					break;

 				}

 			}

 		} else {

 			return response()->json( [ 'errors' => ___('Not found.') ] );

 		}

 	}

 	public function index() {

 		return view('tasks.index');

 	}

 	public function browseWorking() {

 		return view('tasks.browse.working');

 	}

 	public function browseDue() {

 		return view('tasks.browse.due');

 	}

 	public function browseLate() {

 		return view('tasks.browse.late');

 	}

 	public function browsePipeline() {

 		return view('tasks.browse.pipeline');

 	}

 	public function browseFollowups() {

 		return view('tasks.browse.followups');

 	}

 	public function apiBrowseDue( Request $R ) {

 		$when = $when_modified = str_replace( '+', ' ', $R->route('when', 'today') );
 		$user_id = get_user_id();
 		$project_id = get_project_id();

 		$sort = $R->input('sort', [ 'field' => 'priority', 'order' => 'asc', 'show_completed' => false ] );

 		if ( in_array( $when, [ 'yesterday', 'today', 'tomorrow' ] ) ) {

	 		$due_date = Carbon::parse( Carbon::parse( $when )->toDateString() )->addDays( 1 )->addMinutes( -1 )->toDateString();

	 	} else {

	 		$range = true;

	 		switch ( $when ) {

	 			case 'this week':

	 				$when_modified = 'last week sunday';
	 				$due_date_start = Carbon::parse( $when_modified )->toDateString();
	 				$due_date_end = Carbon::parse( $when_modified )->addWeeks(1)->toDateString();

	 			break;

	 			case 'next week':

	 				$when_modified = 'this week sunday';
	 				$due_date_start = Carbon::parse( $when_modified )->toDateString();
	 				$due_date_end = Carbon::parse( $when_modified )->addWeeks(1)->toDateString();

	 			break;

	 			case 'this month':

	 				$when_modified = 'first day of this month';
	 				$due_date_start = Carbon::parse( $when_modified )->toDateString();
	 				$due_date_end = Carbon::parse( $when_modified )->addMonths(1)->toDateString();

	 			break;

	 			case 'next month':

	 				$when_modified = 'first day of next month';
	 				$due_date_start = Carbon::parse( $when_modified )->toDateString();
	 				$due_date_end = Carbon::parse( $when_modified )->addMonths(1)->toDateString();

	 			break;

	 		}

	 	}

 		$tasks = Task::where('user_id', $user_id)->where('project_id', $project_id)->with('task_items', 'followups');

		if ( $range ?? false ) {

			$tasks = $tasks->whereBetween('due_date', [ $due_date_start, $due_date_end ] );

		} else {

			$tasks = $tasks->where('due_date', $due_date);

		}

		if ( !( $sort['show_completed'] ?? false ) ) {

 			$tasks = $tasks->where('completed', 0);

 		}

		if ( in_array( $sort['field'] ?? 'priority', [ 'priority', 'completion' ] ) ) {

			$sort_field = $sort['field'];
			$sort_order = ( $sort['order'] ?? 'asc' ) == 'desc' ? 'desc' : 'asc';

			$tasks = $tasks->orderBy( $sort_field, $sort_order );

		}

		if ( $sort['limit'] ?? false ) {

			$tasks = $tasks->take( $sort['limit'] );

		}

 		$tasks = $tasks->get();

 		return response()->json( [ 'tasks' => $tasks, 'mode' => 'due' ] );

 	}

 	public function apiBrowseWorking( Request $R ) {

 		$when = 'today';
 		$user_id = get_user_id();
 		$project_id = get_project_id();
 		$sort = $R->input('sort', [ 'field' => 'priority', 'order' => 'asc', 'show_completed' => false ] );

 		$tasks = Task::where('user_id', $user_id)->where('project_id', $project_id)->with([ 'task_items' => function($q){ $q->where('completed', 0); }, 'followups' ])->where('working', 1);

		$tasks = $tasks->where('completed', 0);

 		if ( in_array( $sort['field'] ?? 'priority', [ 'priority', 'completion' ] ) ) {

			$sort_field = $sort['field'];
			$sort_order = ( $sort['order'] ?? 'asc' ) == 'desc' ? 'desc' : 'asc';

			$tasks = $tasks->orderBy( $sort_field, $sort_order );

		}

		if ( $sort['limit'] ?? false ) {

			$tasks = $tasks->take( $sort['limit'] );

		}

 		$tasks = $tasks->get();

 		return response()->json( [ 'tasks' => $tasks, 'mode' => 'working' ] );

 	}

 	public function apiBrowseLate( Request $R ) {

 		$when = 'today';
 		$user_id = get_user_id();
 		$project_id = get_project_id();
 		$sort = $R->input('sort', [ 'field' => 'priority', 'order' => 'asc', 'show_completed' => false ] );

 		$due_date = Carbon::parse( Carbon::parse( $when )->toDateString() );

 		$tasks = Task::where('user_id', $user_id)->where('project_id', $project_id)->with('task_items', 'followups');

		$tasks = $tasks->where('due_date', '<', $due_date)->where('completed', 0);

 		if ( in_array( $sort['field'] ?? 'priority', [ 'priority', 'completion' ] ) ) {

			$sort_field = $sort['field'];
			$sort_order = ( $sort['order'] ?? 'asc' ) == 'desc' ? 'desc' : 'asc';

			$tasks = $tasks->orderBy( $sort_field, $sort_order );

		}

		if ( $sort['limit'] ?? false ) {

			$tasks = $tasks->take( $sort['limit'] );

		}

 		$tasks = $tasks->get();

 		return response()->json( [ 'tasks' => $tasks, 'mode' => 'late' ] );

 	}

 	public function apiBrowsePipeline( Request $R ) {

 		$when = $R->route('when', 'today');
 		$user_id = get_user_id();
 		$project_id = get_project_id();
 		$sort = $R->input('sort', [ 'field' => 'priority', 'order' => 'asc', 'show_completed' => false ] );

 		$due_date_start = Carbon::parse( $when )->toDateString();
 		$due_date = Carbon::parse( $due_date_start )->addDays( 1 )->addMinutes( -1 )->toDateString();

 		$tasks = Task::where('user_id', $user_id)->where('project_id', $project_id)->with('task_items', 'followups');

 		$tasks = $tasks->where('start_date', '<=', $due_date_start);
		$tasks = $tasks->where('due_date', '>=', $due_date);

 		if ( !$R->input('show_completed', false) ) {

 			$tasks = $tasks->where('completed', 0);

 		}

 		if ( in_array( $sort['field'] ?? 'priority', [ 'priority', 'completion' ] ) ) {

			$sort_field = $sort['field'];
			$sort_order = ( $sort['order'] ?? 'asc' ) == 'desc' ? 'desc' : 'asc';

			$tasks = $tasks->orderBy( $sort_field, $sort_order );

		}

		if ( $sort['limit'] ?? false ) {

			$tasks = $tasks->take( $sort['limit'] );

		}

 		$tasks = $tasks->get();

 		return response()->json( [ 'tasks' => $tasks, 'mode' => 'pipeline' ] );

 	}

 	public function apiBrowseFollowups( Request $R ) {

 		$when = $R->route('when', 'today');
 		$user_id = get_user_id();
 		$project_id = get_project_id();
 		$sort = $R->input('sort', [ 'field' => 'priority', 'order' => 'asc', 'show_completed' => false ] );

 		$due_date = Carbon::now()->toDateString();

	 	$tasks = Task::where('user_id', $user_id)->where('project_id', $project_id)->with(['followups' => function ( $q ) { $q->where('completed', 0 ); }] );

	 	if ( $when != 'late' ) {

			$tasks = $tasks->whereHas( 'followups', function( $q ) 
																									use ( $due_date ) 
																								{
																									$q->where('due_date', $due_date );
																									$q->where('completed', 0 );
																								} );

		} else {

				$tasks = $tasks->whereHas( 'followups', function( $q ) 
																									use ( $due_date ) 
																								{
																									$q->where('due_date', '<', $due_date );
																									$q->where('completed', 0 );
																								} );

		}

 		if ( in_array( $sort['field'] ?? 'priority', [ 'priority', 'completion' ] ) ) {

			$sort_field = $sort['field'];
			$sort_order = ( $sort['order'] ?? 'asc' ) == 'desc' ? 'desc' : 'asc';

			$tasks = $tasks->orderBy( $sort_field, $sort_order );

		}

		if ( $sort['limit'] ?? false ) {

			$tasks = $tasks->take( $sort['limit'] );

		}

 		$tasks = $tasks->get();

 		return response()->json( [ 'tasks' => $tasks, 'mode' => 'followups' ] );

 	}

 	public function parseBulkItems( Request $R ) {

 		$items = $R->input('task_items');

 		if ( !$items ) return response()->json( [] );

 		$items = explode( "\n", $items );
 		$task_items = [];

 		foreach ( $items as $item ) {

 			$item_parts = explode( ' ', $item );

 			if ( count( $item_parts ) > 1 ) {

 				$priority = is_numeric( $item_parts[0] ) ? $item_parts[0] : '';

 				if ( $priority ) {

	 				$title = trim( str_replace( $priority, '', $item ) );
	 				$priority = (float) $priority;

	 			} else {

	 				$title = $item;

	 			}

 			} else {

 				$priority = '';
 				$title = $item;

 			}

 			$task_items[] = [ 'priority' => $priority, 'title' => $title ];

 		}

 		return response()->json( $task_items );

 	}

}
