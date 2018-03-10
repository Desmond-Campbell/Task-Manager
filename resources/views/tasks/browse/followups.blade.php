@extends('layouts.app')

@section('title')

{{ ___("Follow-up") }}

@stop

@section('content')

<div id="BrowseController">

	<h1>{{ ___("For Follow-up") }}</h1>

	<ul class="filter-menu">
		<li><a href="#" @click="getTasks('today')">{{___('Today')}}</a></li>
		<li><a href="#" @click="getTasks('late')">{{___('Outstanding')}}</a></li>
	</ul>

	<div class="row">

		<div class="col-md-8">
			<a href="#" @click="sortBy('priority')">
				{{___('Priority')}}
				<span v-if="sort.field == 'priority'">
					<i class="fa fa-chevron-up" v-if="sort.order == 'asc'"></i>
					<i class="fa fa-chevron-down" v-if="sort.order == 'desc'"></i>
				</span>
			</a>

			&nbsp; &nbsp;

			<a href="#" @click="sortBy('completion')">
				{{___('Completion')}}
				<span v-if="sort.field == 'completion'">
					<i class="fa fa-chevron-up" v-if="sort.order == 'asc'"></i>
					<i class="fa fa-chevron-down" v-if="sort.order == 'desc'"></i>
				</span>
			</a>

			&nbsp; &nbsp;
	
			<input type="checkbox" id="show-completed" v-model="sort.show_completed" :value="true" @click="fetchTasks();" /><label for="show-completed" @click="fetchTasks();"> &nbsp; {{___('Show completed tasks')}}</label>

		</div>

	</div>

	<div class="row">

		<div class="col-md-8"> 

			<div v-for="( task, t ) in tasks">

				<div class="row task-entry">
					<div class="col-md-1 task-entry-lead">
						<div class="task-entry-priority">@{{ task.priority }}</div>
						<div class="task-entry-completion">@{{ task.completion }}%</div>
					</div>
					<div class="col-md-10">
						<div class="task-entry-title">
							<a :href="'/edit/' + task.id + '?view_mode=true'">@{{ task.title }}</a> <a :href="'/edit/' + task.id"><i class="fa fa-edit"></i></a>
						</div>
						<div class="task-entry-followups">
							<div v-for="followup in task.followups" class="task-entry-followup-item">
								<div class="task-entry-followup-action">
									@{{ followup.action }}
								</div>
								<div class="task-entry-followup-action">
									@{{ followup.due_date }} | @{{ followup.due_time }}
								</div>
								<div class="task-entry-followup-controls">
									<button class="btn btn-sm btn-secondary" @click="completeFollowup(followup)">{{ ___('Done') }}</button>
									<button class="btn btn-sm btn-secondary" @click="rescheduleFollowup(followup)">{{ ___('Re-schedule') }}</button>
									<button class="btn btn-sm btn-secondary" @click="cancelFollowup(followup)">{{ ___('Cancel') }}</button>
								</div>
							</div>
						</div>
						<div class="task-entry-description">
							@{{ task.customers }} / @{{ task.categories }} / @{{ task.features }}
						</div>
						<div class="task-entry-due-date">
							@{{ task.due_date }} | @{{ task.due_time }}
						</div>
						<div class="task-entry-controls">
							<button class="btn btn-sm btn-secondary" @click="completeTask(task)">{{ ___('Done') }}</button>
							<button class="btn btn-sm btn-secondary" @click="rescheduleTask(task)">{{ ___('Re-schedule') }}</button>
							<button class="btn btn-sm btn-secondary" @click="reassignTask(task)">{{ ___('Re-assign') }}</button>
							<button class="btn btn-sm btn-secondary" @click="followupTask(task)">{{ ___('Follow-up') }}</button>
							<button class="btn btn-sm btn-secondary" @click="cancelTask(task)">{{ ___('Cancel') }}</button>
						</div>
					</div>
					<div class="col-md-1">
						@{{ task.assignees }}
					</div>
				</div>
			
			</div>

		</div>

		<div class="col-md-4">

			@include('tasks.browse.due-today')

		</div>

</div>

@stop

@section('javascript-controllers')
<script type="text/javascript" src="/js/controllers/BrowseController.js"></script>
<script type="text/javascript">vm.mode = 'followups'; vm.fetchTasks();</script>
@stop