var vm = new Vue({

	el : '#TaskController',
	
	data : { 
						id : 0, 
						task : { title : '', task_items : [], task_items_completed : [], followups : [] },
						task_items_bulk : [],
						taskItemEditId : -1, 
						followupEditId : -1,
						editMode : 'details', 
						taskItemEditMode : 'regular',
						newTaskItemMode : false
					},
	
	methods : {

		fetchTask : function () {

			if ( this.id < 1 ) {

				this.id = jQuery('#task_id').val();
				
			}

			if ( this.id > 0 ) {

				axios.get( '/api/tasks/' + this.id + '/get' ).then( 

					function ( response ) {

						vm.task = response.data.task;

					},

					function () {

						alertError( general_error_failure );

					}

				);

			} else {

				this.task = { title : '', task_items : [], task_items_completed : [],followups : [] };

			}

		},

		updateTask : function () {

			axios.post( '/api/tasks/' + this.id + '/update', this.task ).then( 

				function ( response ) {

					if ( typeof response.data.errors !== 'undefined' ) {

						alertError( response.data.errors );

					} else {

						vm.taskItemEditId = -1;
						vm.followupEditId = -1;
						vm.id = response.data.task.id;

						vm.fetchTask();

						alertSuccess( ___t('Saved.') );

					}

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		addTaskItemsBulk : function () {

			axios.post( '/api/tasks/' + this.id + '/parse-items-bulk', { task_items : this.task_items_bulk } ).then( 

				function ( response ) {

					if ( typeof response.data.errors !== 'undefined' ) {

						alertError( response.data.errors );

					} else {

						for ( i = 0; i < response.data.length; i++ ) {

							vm.task.task_items.push( response.data[i] );

						}

						vm.task_items_bulk = '';
						vm.taskItemEditMode = 'regular';

					}

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		saveNotes : function (notes) {

			axios.post( '/api/tasks/' + this.id + '/save-notes', { notes : notes } ).then( 

				function ( response ) {

					if ( typeof response.data.errors !== 'undefined' ) {

						alertError( response.data.errors );

					} else {


					}

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		deleteTask : function () {

			if ( alertConfirm( ___t( 'Delete this task item?' ) ) ) {

				axios.delete( '/api/tasks/' + this.id + '/delete', this.task ).then( 

					function ( response ) {

						if ( typeof response.data.errors !== 'undefined' ) {

							alertError( response.data.errors );

						} else {

							vm.followupEditId = -1;
							vm.id = 0;
							vm.task = { title : '', task_items : [], task_items_completed : [],followups : [] };

						}

					},

					function () {

						alertError( general_error_failure );

					}

				);

			}

		},

		addTaskItem : function () {

			index = vm.task.task_items.length;
			vm.task.task_items.push({});
			vm.taskItemEditId = index;

			vm.refresh();

		},

		deleteTaskItem : function ( index ) {

			if ( alertConfirm( ___t( 'Delete this task item?' ) ) ) {

				vm.task.task_items[index].deleted = true;
				vm.taskItemEditId = -1;
				vm.refresh();

			}

		},

		insertTaskItemUp : function ( index ) {

			vm.task.task_items.splice( index, 0, {} );

		},

		insertTaskItemDown : function ( index ) {

			vm.task.task_items.splice( index + 1, 0, {} );
			
		},

		moveTaskItemUp : function ( index ) {

			vm.task.task_items.move( index, index - 1 );

		},

		moveTaskItemDown : function ( index ) {

			vm.task.task_items.move( index, index + 1 );

		},

		addFollowup : function () {

			index = vm.task.followups.length;
			vm.task.followups.push({});
			vm.followupEditId = index;

			vm.refresh();

		},

		deleteFollowup : function ( index ) {

			if ( alertConfirm( ___t( 'Delete this followup item?' ) ) ) {

				vm.task.followups[index].deleted = true;
				vm.followupEditId = -1;
				vm.refresh();

			}

		},


		/****************/

		enlistTask : function ( task ) {

			axios.post( '/api/tasks/' + task.id + '/action', { task : task, action : 'enlist' } ).then( 

				function ( response ) {

					vm.fetchTask();

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		delistTask : function ( task ) {

			axios.post( '/api/tasks/' + task.id + '/action', { task : task, action : 'delist' } ).then( 

				function ( response ) {

					vm.fetchTask();

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		completeTask : function ( task ) {

			axios.post( '/api/tasks/' + task.id + '/action', { task : task, action : 'complete' } ).then( 

				function ( response ) {

					vm.fetchTask();

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

					vm.fetchTask();

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

					vm.fetchTask();

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

					vm.fetchTask();

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		reprioritiseTask : function ( task ) {

			var priority = prompt("priority:", task.priority);

			if ( !priority ) { return; }
			
			axios.post( '/api/tasks/' + task.id + '/action', { task : task, priority : priority, action : 'reprioritise' } ).then( 

				function ( response ) {

					vm.fetchTask();

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		completeTaskItem : function ( task_item ) {

			axios.post( '/api/tasks/' + vm.task.id + '/action', { task_item : task_item, action : 'complete_task_item' } ).then( 

				function ( response ) {

					vm.fetchTask();

				},

				function () {

					alertError( general_error_failure );

				}

			);

		},

		incompleteTaskItem : function ( task_item ) {

			axios.post( '/api/tasks/' + vm.task.id + '/action', { task_item : task_item, action : 'incomplete_task_item' } ).then( 

				function ( response ) {

					vm.fetchTask();

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

						vm.fetchTask();

					},

					function () {

						alertError( general_error_failure );

					}

				);

			}

		},

		/****************/

		refresh : function () {

			vm.$forceUpdate();

		}

	},

	mounted() {

		// Get task and details
		this.fetchTask();

	},

	filters : {
	  moment: function (date, format) {
	    return moment(date).format(format);
	  }
	}


});
