@extends('layouts.app')

@section('title')

{{ ___("Working List") }}

@stop

@section('content')

<div id="BrowseController">

	<h1>{{ ___("Working List") }}</h1>

	<div class="row">

		<div class="col-md-8">
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

		</div>

	</div>

	<div class="row">

		<div class="col-md-8"> 

			<div v-for="( task, t ) in tasks">

				<div class="row task-entry">
					
					<div class="col-md-12">
						<div class="task-entry-title no-bold" style="font-size: 90%">
							<a :href="'/edit/' + task.id"><strong>@{{ task.priority }} @{{ task.completion }}%</strong> @{{ task.title }}</a> <button class="btn btn-secondary btn-sm" @click="delistTask(task)">{{___('x')}}</button>
						</div>
				
						<div v-for="item in task.task_items">
							<div>
								<span @click="completeTaskItem(item)" class="clickable"><i class="far fa-square"></i> &nbsp; </span> @{{ item.title }} &nbsp; <span class="badge badge-warning">@{{ item.priority }}</span>
							</div>
						</div>
				
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
<script type="text/javascript">vm.mode = 'working'; vm.fetchTasks(); </script>
@stop