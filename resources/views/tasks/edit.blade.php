@extends('layouts.app')

@section('title')

{{ ___('Edit Task') }}

@stop

@section('content')

<div id="TaskController">

	<h1>@{{ task.title }} <button class="btn btn-md btn-success" @click="updateTask()">{{___('Save')}}</button> <button class="btn btn-md btn-danger" @click="deleteTask()"><i class="fa fa-trash"></i></button></h1>

	<ul class="filter-menu">
		<li><a href="#" @click="editMode = 'details'">{{___('Details')}}</a></li>
		<li><a href="#" @click="editMode = 'task_items'">{{___('Task Items')}}</a></li>
		<li><a href="#" @click="editMode = 'followups'">{{___('Followups')}}</a></li>
	</ul>

	<div class="row">

		<div class="col-md-6">

			<div v-show="editMode == 'details'">

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

			<div v-show="editMode == 'task_items'">

				<button class="btn btn-primary" @click="addTaskItem()"><i class="fa fa-plus"></i></button>

				<table class="table no-borders striped push-down" v-if="task.task_items.length > 0">

					<tbody v-for="(task_item, i) in task.task_items">

						<tr v-if="taskItemEditId != i && !task_item.deleted">
							<td width="20%">@{{task_item.priority}}</td>
							<td>@{{task_item.title}}</td>
							<td><a href="#" @click="taskItemEditId = i; refresh()"><i class="fa fa-edit"></i></a> &nbsp; <a href="#" @click="deleteTaskItem(i)"><i class="fa fa-trash"></i></a></td>
						</tr>

						<tr v-if="taskItemEditId == i">
							<td width="20%"><input type="text" class="form-control input-sm" v-model="task_item.priority" /></td>
							<td><input type="text" class="form-control input-sm" v-model="task_item.title" /></td>
							<td><a href="#" @click="taskItemEditId = -1"><i class="fa fa-check"></i></a> &nbsp; <a href="#" @click="deleteTaskItem(i)"><i class="fa fa-trash"></i></a></td>
						</tr>

					</tbody>

				</table>

			</div>

			<div v-show="editMode == 'followups'">

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

	</div>

</div>

@stop

@section('javascript-controllers')
<script type="text/javascript" src="/js/controllers/TaskController.js"></script>
@stop