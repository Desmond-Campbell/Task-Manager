var vm = new Vue({

	el : '#BrowseController',
	
	data : { 
						period : 'today',
						tasks : [],
						mode : 'due',
						query : '',
						sort : { field : 'priority', order : 'asc', show_completed : false } 
					},
	
	methods : {

		fetchTasks : function () {

			$url = '/api/tasks/' + this.mode + '/' + this.period;

			if ( vm.mode == 'search' ) {

				$url = '/search/' + this.query;

			}

			axios.post( $url, { sort : this.sort } ).then( 

				function ( response ) {

					vm.tasks = response.data.tasks;
					vm.refresh();

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		completeTask : function ( task ) {

			if ( alertConfirm( ___t('Done?') ) ) {

				axios.post( '/api/tasks/' + task.id + '/action', { task : task, action : 'complete' } ).then( 

					function ( response ) {

						vm.fetchTasks();

					},

					function () {

						alertError( general_error_failure );

					}

				);

			}

		},

		completeTaskItem : function ( task_item ) {

			axios.post( '/api/tasks/' + task_item.task_id + '/action', { task_item : task_item, action : 'complete_task_item' } ).then( 

				function ( response ) {

					vm.fetchTasks();

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		enlistTask : function ( task ) {

			axios.post( '/api/tasks/' + task.id + '/action', { task : task, action : 'enlist' } ).then( 

				function ( response ) {

					vm.fetchTasks();

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		delistTask : function ( task ) {

			axios.post( '/api/tasks/' + task.id + '/action', { task : task, action : 'delist' } ).then( 

				function ( response ) {

					vm.fetchTasks();

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		followupTask : function ( task ) {

			var followup_action = prompt("Follow-up action:", "");
			var due = prompt("Due date and time:", "");
	
			if ( !action || !due ) { return; }

			axios.post( '/api/tasks/' + task.id + '/action', { task : task, followup_action : followup_action, due : due, action : 'followup' } ).then( 

				function ( response ) {

					vm.fetchTasks();

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		rescheduleTask : function ( task ) {

			var due = prompt("Due date and time:", "");

			if ( !due ) { return; }
			
			axios.post( '/api/tasks/' + task.id + '/action', { task : task, due : due, action : 'reschedule' } ).then( 

				function ( response ) {

					vm.fetchTasks();

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		reassignTask : function ( task ) {

			var assignees = prompt("Assignees:", "");

			if ( !assignees ) { return; }
			
			axios.post( '/api/tasks/' + task.id + '/action', { task : task, assignees : assignees, action : 'reassign' } ).then( 

				function ( response ) {

					vm.fetchTasks();

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		cancelTask : function ( task ) {

			if ( alertConfirm( ___t('Cancel?') ) ) {

				console.log('aaaaa')

				axios.post( '/api/tasks/' + task.id + '/action', { task : task, action : 'cancel' } ).then( 

					function ( response ) {

						vm.fetchTasks();

					},

					function () {

						alertError( general_error_failure );

					}

				);

			}

		},

		reprioritiseTask : function ( task ) {

			var priority = prompt("priority:", task.priority);

			if ( !priority ) { return; }
			
			axios.post( '/api/tasks/' + task.id + '/action', { task : task, priority : priority, action : 'reprioritise' } ).then( 

				function ( response ) {

					vm.fetchTasks();

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		completeFollowup : function ( followup ) {

			axios.post( '/api/tasks/' + followup.task_id + '/action', { followup : followup, action : 'complete_followup' } ).then( 

				function ( response ) {

					vm.fetchTasks();

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		rescheduleFollowup : function ( followup ) {

			var due = prompt("Due date and time:", "");

			if ( !due ) { return; }
			
			axios.post( '/api/tasks/' + followup.task_id + '/action', { followup : followup, due : due, action : 'reschedule_followup' } ).then( 

				function ( response ) {

					vm.fetchTasks();

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		cancelFollowup : function ( followup ) {

			if ( alertConfirm( ___t('Cancel?') ) ) {

				axios.post( '/api/tasks/' + followup.task_id + '/action', { followup : followup, action : 'cancel_followup' } ).then( 

					function ( response ) {

						vm.fetchTasks();

					},

					function () {

						alertError( general_error_failure );

					}

				);

			}

		},
		getTasks : function (period) {

			vm.period = period;

			vm.fetchTasks();

		},

		sortBy : function (field) {

			vm.sort.field = field;
			vm.sort.order = vm.sort.order == 'asc' ? 'desc' : 'asc';

			vm.fetchTasks();

		},

		refresh : function () {

			vm.$forceUpdate();

		}

	},

	mounted() {

	},

});
