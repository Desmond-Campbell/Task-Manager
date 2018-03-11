var vm = new Vue({

	el : '#BrowseController',
	
	data : { 
						period : 'today',
						tasks : [],
						mode : 'due',
						sort : { field : 'priority', order : 'asc', show_completed : false } 
					},
	
	methods : {

		fetchTasks : function () {

			axios.post( '/api/tasks/' + this.mode + '/' + this.period, { sort : this.sort } ).then( 

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
