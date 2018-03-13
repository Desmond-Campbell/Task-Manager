@extends('layouts.app')

@section('title')

{{ $title ?? ___('New Task') }}

@stop

@section('content')

<div id="TaskController">

	<h1>@{{ task.title }}</h1>

	<div class="task-title-controls">
		<h4><span class="badge badge-default">@{{ task.priority }}</span> <span class="badge badge-info">@{{ task.completion }}%</span> <button class="btn btn-sm btn-secondary" @click="updateTask()">{{___('Save')}}</button> <button class="btn btn-sm btn-secondary" @click="deleteTask()"><i class="fa fa-trash"></i></button> <button class="btn btn-sm btn-secondary" @click="task.expanded = !task.expanded; refresh()"><i class="fa fa-chevron-down" v-show="task.expanded"></i><i class="fa fa-chevron-up" v-show="!task.expanded"></i></button></h4>
	</div>

	<br />

	<ul class="filter-menu">
		<li :class="{ 'active' : editMode == 'view' }"><a href="#" @click="editMode = 'view'">{{___('View')}}</a></li>
		<li :class="{ 'active' : editMode == 'details' }"><a href="#" @click="editMode = 'details'">{{___('Edit')}}</a></li>
		<li :class="{ 'active' : editMode == 'task_items' }"><a href="#" @click="editMode = 'task_items'">{{___('Task Items')}}</a></li>
		<li :class="{ 'active' : editMode == 'followups' }"><a href="#" @click="editMode = 'followups'">{{___('Followups')}}</a></li>
	</ul>

	<div class="row">

		<div class="col-md-6">

			<div v-show="task.expanded">

				<p>
					{{ ___('Due') }}: <strong>@{{ task.due_date | moment( "MMMM D" ) }} {{__('at')}} @{{ task.due_date + ' ' + task.due_time | moment( "h:mm a" )  }}</strong> | {{ ___('Starts') }}: <strong>@{{ task.start_date | moment( "MMMM D" ) }} {{__('at')}} @{{ task.start_date + ' ' + task.start_time | moment( "h:mm a" )  }}</strong>
				</p>

				<div class="view-task-controls">
					<button class="btn btn-secondary btn-sm" @click="completeTask(task)"><i class="fa fa-check hidden-md-up"></i><span class="hidden-sm-down">{{___('Done')}}</span></button>
					<button class="btn btn-sm btn-secondary" @click="enlistTask(task)" v-show="!task.working"><i class="fa fa-play hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Enlist') }}</span></button>
					<button class="btn btn-sm btn-secondary" @click="delistTask(task)" v-show="task.working"><i class="fa fa-stop hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Delist') }}</span></button>
					<button class="btn btn-secondary btn-sm" @click="rescheduleTask(task)"><i class="fa fa-clock hidden-md-up"></i><span class="hidden-sm-down">{{___('Re-schedule')}}</span></button>
					<button class="btn btn-secondary btn-sm" @click="followupTask(task)"><i class="fa fa-share hidden-md-up"></i><span class="hidden-sm-down">{{___('Follow-up')}}</span></button>
					<button class="btn btn-secondary btn-sm" @click="reprioritiseTask(task)"><i class="fa fa-exclamation hidden-md-up"></i><span class="hidden-sm-down">{{___('Re-prioritise')}}</span></button>
					<button class="btn btn-secondary btn-sm" @click="cancelTask(task)"><i class="fa fa-times hidden-md-up"></i><span class="hidden-sm-down">{{___('Cancel')}}</span></button>
				</div>

				<div class="task-view-info push-down">
					@{{ task.customers }} / @{{ task.categories }} / @{{ task.features }}
				</div>

			</div>

			<div v-show="editMode == 'view'" class="push-down">

				<div class="task-view-description">
					@{{ task.description }}
				</div>

				<div class="task-view-task-items push-down">
					
					<div v-for="( task_item, t ) in task.task_items_incomplete" class="task-view-task-item">

						<span @click="completeTaskItem(task_item)" class="clickable"><i class="far fa-square"></i> &nbsp; <span class="badge badge-warning">@{{ task_item.priority }}</span> &nbsp; @{{ task_item.title }}</span>

					</div>

					<hr />

					<div v-for="( task_item, t ) in task.task_items_complete" class="task-view-task-item">

						<span @click="incompleteTaskItem(task_item)" class="clickable"><i class="fa fa-check-square"></i> &nbsp; <span class="badge badge-success">@{{ task_item.priority }}</span> &nbsp; @{{ task_item.title }}</span>

					</div>

				</div>

			</div>

			<div v-show="editMode == 'details'" class="push-down">

				<input type="hidden" name="task_id" id="task_id" value="{{ $task_id ?? 0 }}" />

				<div class="form-group">
					<label>{{___('Title')}}</label>
					<input type="text" class="form-control" v-model="task.title" />
				</div>

				<div class="form-group">
					<label>{{___('Priority')}}</label>
					<input type="text" class="form-control" v-model="task.priority" />
				</div>

				<div class="form-group">
					<label>{{___('Description')}}</label>
					<textarea class="form-control" v-model="task.description"></textarea>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-4"><label class="">{{___('Start Date')}}</label></div>
						<div class="col-md-4"><input type="text" class=" form-control" v-model="task.start_date" /></div>
						<div class="col-md-4"><input type="text" class=" form-control" v-model="task.start_time" /></div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-4"><label class="">{{___('Due Date')}}</label></div>
						<div class="col-md-4"><input type="text" class=" form-control" v-model="task.due_date" /></div>
						<div class="col-md-4"><input type="text" class=" form-control" v-model="task.due_time" /></div>
					</div>
				</div>

				<div class="form-group">
					<label>{{___('Customer')}}</label>
					<input type="text" class="form-control" v-model="task.customers" />
				</div>

				<div class="form-group">
					<label>{{___('Category')}}</label>
					<input type="text" class="form-control" v-model="task.categories" />
				</div>

				<div class="form-group">
					<label>{{___('Features')}}</label>
					<input type="text" class="form-control" v-model="task.features" />
				</div>

				<div class="form-group">
					<label>{{___('Assigned To')}}</label>
					<input type="text" class="form-control" v-model="task.assignees" />
				</div>

			</div>

			<div v-show="editMode == 'task_items'" class="push-down">

				<div v-show="taskItemEditMode == 'regular'">

					<button class="btn btn-primary" @click="addTaskItem(); newTaskItemMode = true; refresh()"><i class="fa fa-plus"></i></button> &nbsp;
					<button class="btn btn-warning" @click="taskItemEditMode = 'bulk'; refresh()"><i class="fa fa-plus-square"></i></button>

					<table class="table no-borders striped push-down" v-if="task.task_items.length > 0">

						<tbody v-for="(task_item, i) in task.task_items">

							<tr v-if="taskItemEditId != i && !task_item.deleted && !newTaskItemMode">
								<td width="20%">@{{task_item.priority}}</td>
								<td>@{{task_item.title}}</td>
								<td><a href="#" @click="taskItemEditId = i; refresh()"><i class="fa fa-edit"></i></a> &nbsp; <a href="#" @click="deleteTaskItem(i); newTaskItemMode = false"><i class="fa fa-trash"></i></a></td>
							</tr>

							<tr v-if="taskItemEditId == i">
								<td width="20%"><input type="text" class="form-control input-sm" v-model="task_item.priority" /></td>
								<td><input type="text" class="form-control input-sm" v-model="task_item.title" /></td>
								<td><a href="#" @click="taskItemEditId = -1; newTaskItemMode = false"><i class="fa fa-check"></i></a> &nbsp; <a href="#" @click="deleteTaskItem(i); newTaskItemMode = false"><i class="fa fa-trash"></i></a></td>
							</tr>

						</tbody>

					</table>

				</div>

				<div v-show="taskItemEditMode == 'bulk'">

					<button class="btn btn-primary" @click="taskItemEditMode = 'regular'; refresh()"><i class="fa fa-plus"></i></button> &nbsp;
					<button class="btn btn-secondary" @click="taskItemEditMode = 'regular'; refresh()"><i class="fa fa-chevron-left"></i></button>

					<br />

					<div class="form-group push-down">
						<textarea class="form-control" style="padding: 25px; font-size: 85%; border:none; border-top: dotted 1px #ccc" rows="10" v-model="task_items_bulk"></textarea>
					</div>

					<div class="form-group">
						<button class="btn btn-success" @click="addTaskItemsBulk()">{{___('Save')}}</button>
						<button class="btn btn-warning" @click="task_items_bulk = ''; taskItemEditMode = 'regular'; refresh()">{{___('Cancel')}}</button>
					</div>

				</div>

			</div>

			<div v-show="editMode == 'followups'" class="push-down">

				<button class="btn btn-primary" @click="addFollowup()"><i class="fa fa-plus"></i></button>

				<table class="table no-borders striped push-down" v-if="task.followups.length > 0">

					<tbody v-for="(followup, i) in task.followups">

						<tr v-if="followupEditId != i && !followup.deleted">
							<td>@{{followup.action}} | @{{followup.due_date}} @{{followup.due_time}}</td>
							<td><a href="#" @click="followupEditId = i; refresh()"><i class="fa fa-edit"></i></a> &nbsp; <a href="#" @click="deleteFollowup(i)"><i class="fa fa-trash"></i></a></td>
						</tr>

						<tr v-if="followupEditId == i">
							<td>{{ ___('Action') }}: <br /><input type="text" class="form-control input-sm" v-model="followup.action" /><br />
								{{___('Due Date/Time') }}:
								<div class="row">
									<div class="col-md-6"><input type="text" class="form-control input-sm" v-model="followup.due_date" /></div>
									<div class="col-md-6"><input type="text" class="form-control input-sm" v-model="followup.due_time" /></div>
								</div>
							</td>
							<td><a href="#" @click="followupEditId = -1"><i class="fa fa-check"></i></a> &nbsp; <a href="#" @click="deleteFollowup(i)"><i class="fa fa-trash"></i></a></td>
						</tr>

					</tbody>

				</table>

			</div>

		</div>

		<div class="col-md-6 task-notes">

			<h6>{{___('Notes')}}</h6>
			<textarea class="form-control" style="padding: 0px; padding-right: 25px; font-size: 85%; border:none" rows="30" v-model="task.notes" @change="saveNotes(task.notes)" @blur="saveNotes(task.notes)"></textarea>

		</div>

	</div>

</div>

@stop

@section('javascript-controllers')
<script type="text/javascript" src="/js/controllers/TaskController.js"></script>
<script type="text/javascript">
@if ( $task_id )
vm.editMode = 'view';
@endif
</script>
@stop