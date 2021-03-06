@extends('layouts.app')

@section('title')

{{ ___("Search Results") }}

@stop

@section('content')

<div id="BrowseController">

	<div style="padding: 10px">
		<form class="form-inline" action="/search" style="margin-top: -15px; margin-bottom: 20px">
	    <input class="form-control mr-sm-2" type="text" name="query" placeholder="{{___('Search')}}" value="{{ request('query') }}">
	    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{___('Search')}}</button>
	  </form>
	</div>

	<div class="row">

		<div class="col-md-8">
	{{-- 
			<a href="javascript:;" @click="sortBy('priority')">
				{{___('Priority')}}
				<span v-if="sort.field == 'priority'">
					<i class="fa fa-chevron-up" v-if="sort.order == 'asc'"></i>
					<i class="fa fa-chevron-down" v-if="sort.order == 'desc'"></i>
				</span>
			</a>

			&nbsp; &nbsp;

			<a href="javascript:;" @click="sortBy('completion')">
				{{___('Completion')}}
				<span v-if="sort.field == 'completion'">
					<i class="fa fa-chevron-up" v-if="sort.order == 'asc'"></i>
					<i class="fa fa-chevron-down" v-if="sort.order == 'desc'"></i>
				</span>
			</a>

			&nbsp; &nbsp;

	 --}}
	
			<input type="checkbox" id="show-completed" v-model="sort.show_completed" :value="true" @click="fetchTasks();" /><label for="show-completed" @click="fetchTasks();"> &nbsp; {{___('Completed')}}</label>

		</div>

	</div>

	<div class="row">

		<div class="col-md-8"> 

			<div v-for="( task, t ) in tasks">

				<div class="row task-entry">
					<div class="col-xlg-1 col-lg-1 col-md-1 col-sm-1 col-xs-12 hidden-sm-down task-entry-lead">
						<div class="task-entry-priority">@{{ task.priority }}</div>
						<div class="task-entry-completion">@{{ task.completion }}%</div>
					</div>
					<div class="col-xs-11 col-sm-11 col-md-11 col-sm-12 col-xs-12 hidden-md-up task-entry-lead">
						<div>
							<span class="task-entry-priority">@{{ task.priority }}</span> &nbsp; 
							<span class="task-entry-completion">@{{ task.completion }}%</span>
						</div>
					</div>

					<div class="col-xlg-11 col-lg-11 col-md-11 col-sm-11 col-xs-12">
						<div class="task-entry-title">
							<a :href="'/edit/' + task.id">@{{ task.title }}</a>
						</div>
						<div class="task-entry-description">
							@{{ task.customers }} / @{{ task.categories }} / @{{ task.features }}
						</div>
						<div class="task-entry-due-date">
							@{{ task.due_date }} | @{{ task.due_time }}
						</div>
						<div class="task-entry-controls">
							<button class="btn btn-sm btn-secondary" @click="completeTask(task)"><i class="fa fa-check hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Done') }}</span></button>
							<button class="btn btn-sm btn-secondary" @click="enlistTask(task)" v-show="!task.working"><i class="fa fa-play hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Enlist') }}</span></button>
							<button class="btn btn-sm btn-secondary" @click="delistTask(task)" v-show="task.working"><i class="fa fa-stop hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Delist') }}</span></button>
							<button class="btn btn-sm btn-secondary" @click="reprioritiseTask(task)"><i class="fa fa-exclamation hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Re-prioritise') }}</span></button>
							<button class="btn btn-sm btn-secondary" @click="rescheduleTask(task)"><i class="fa fa-clock hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Re-schedule') }}</span></button>
							<button class="btn btn-sm btn-secondary" @click="reassignTask(task)"><i class="fa fa-user hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Re-assign') }}</span></button>
							<button class="btn btn-sm btn-secondary" @click="followupTask(task)"><i class="fa fa-share hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Follow-up') }}</span></button>
							<button class="btn btn-sm btn-secondary" @click="cancelTask(task)"><i class="fa fa-times hidden-md-up"></i><span class="hidden-sm-down">{{ ___('Cancel') }}</span></button>
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
<script type="text/javascript">vm.mode = 'search'; vm.query = "{{ request('query') }}"; vm.fetchTasks(); </script>
@stop