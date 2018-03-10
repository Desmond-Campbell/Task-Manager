@extends('layouts.app')

@section('title')

{{ ___("Dashboard") }}

@stop

@section('content')

<div id="DashboardController">

	<div class="row">

		<div class="col-md-8">

			<div class="row">

				<div class="col-md-6 dashboard-section">

					<h3>{{ ___("What's due today?") }}</h3>

					<div v-for="task in tasks.due" class="row dashboard-item dashboard-item-due">
						<div class="col-md-1 task-entry-lead">
							<div class="task-entry-priority">@{{ task.priority }}</div>
							<div class="task-entry-completion">@{{ task.completion }}%</div>
						</div>
						<div class="col-md-10">
							<div class="task-entry-title">
								<a :href="'/edit/' + task.id + '?view_mode=true'">@{{ task.title }}</a> <a :href="'/edit/' + task.id"><i class="fa fa-edit"></i></a>
							</div>
							<div class="task-entry-description">
								@{{ task.customers }} / @{{ task.categories }} / @{{ task.features }}
							</div>
						</div>
						<div class="col-md-1">
							@{{ task.assignees }}
						</div>
					</div>

				</div>

				<div class="col-md-6 dashboard-section">

					<h3>{{ ___("What's late?") }}</h3>

					<div v-for="task in tasks.late" class="row dashboard-item dashboard-item-late">
						<div class="col-md-1 task-entry-lead">
							<div class="task-entry-priority">@{{ task.priority }}</div>
							<div class="task-entry-completion">@{{ task.completion }}%</div>
						</div>
						<div class="col-md-10">
							<div class="task-entry-title">
								<a :href="'/edit/' + task.id + '?view_mode=true'">@{{ task.title }}</a> <a :href="'/edit/' + task.id"><i class="fa fa-edit"></i></a>
							</div>
							<div class="task-entry-description">
								@{{ task.customers }} / @{{ task.categories }} / @{{ task.features }}
							</div>
							<div class="task-entry-due-date">
								@{{ task.due_date }} | @{{ task.due_time }}
							</div>
						</div>
						<div class="col-md-1">
							@{{ task.assignees }}
						</div>
					</div>

				</div>

			</div>

			<div class="row">

				<div class="col-md-6 dashboard-section">

					<h3>{{ ___("What should I follow-up?") }}</h3>

					<div v-for="task in tasks.followups" class="row dashboard-item dashboard-item-followup">
						<div class="col-md-1 task-entry-lead">
							<div class="task-entry-priority">@{{ task.priority }}</div>
							<div class="task-entry-completion">@{{ task.completion }}%</div>
						</div>
						<div class="col-md-10">
							<div class="task-entry-title">
								<a :href="'/edit/' + task.id + '?view_mode=true'">@{{ task.title }}</a> <a :href="'/edit/' + task.id"><i class="fa fa-edit"></i></a>
							</div>
							<div class="task-entry-description">
								@{{ task.customers }} / @{{ task.categories }} / @{{ task.features }}
							</div>
							<div class="task-entry-followups">
								<div v-for="followup in task.followups" class="task-entry-followup-item">
									<div class="task-entry-followup-action">
										@{{ followup.action }}
									</div>
									<div class="task-entry-followup-action-due-date">
										@{{ followup.due_date }} | @{{ followup.due_time }}
									</div>
									<div class="task-entry-followup-controls">
										<button class="btn btn-sm btn-secondary" @click="completeFollowup(followup)">{{ ___('Done') }}</button>
										<button class="btn btn-sm btn-secondary" @click="rescheduleFollowup(followup)">{{ ___('Re-schedule') }}</button>
										<button class="btn btn-sm btn-secondary" @click="cancelFollowup(followup)">{{ ___('Cancel') }}</button>
									</div>
								</div>
							</div>
							<div class="task-entry-due-date">
								@{{ task.due_date }} | @{{ task.due_time }}
							</div>
						</div>
						<div class="col-md-1">
							@{{ task.assignees }}
						</div>
					</div>

				</div>

				<div class="col-md-6 dashboard-section">

					<h3>{{ ___("What's in the pipeline?") }}</h3>

					<div v-for="task in tasks.pipeline" class="row dashboard-item dashboard-item-pipeline">
						<div class="col-md-1 task-entry-lead">
							<div class="task-entry-priority">@{{ task.priority }}</div>
							<div class="task-entry-completion">@{{ task.completion }}%</div>
						</div>
						<div class="col-md-10">
							<div class="task-entry-title">
								<a :href="'/edit/' + task.id + '?view_mode=true'">@{{ task.title }}</a> <a :href="'/edit/' + task.id"><i class="fa fa-edit"></i></a>
							</div>
							<div class="task-entry-description">
								@{{ task.customers }} / @{{ task.categories }} / @{{ task.features }}
							</div>
							<div class="task-entry-due-date">
								@{{ task.due_date }} | @{{ task.due_time }}
							</div>
						</div>
						<div class="col-md-1">
							@{{ task.assignees }}
						</div>
					</div>

				</div>

			</div>

		</div>

		<div class="col-md-4">

			@include('tasks.browse.unscheduled')

		</div>

	</div>

</div>

@stop

@section('javascript-controllers')
<script type="text/javascript" src="/js/controllers/DashboardController.js"></script>
<script type="text/javascript">vm.fetchTasks();</script>
@stop