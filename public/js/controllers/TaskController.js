var vm = new Vue({

	el : '#TaskController',
	
	data : { 
						id : 0, 
						task : { title : '', task_items : [], followups : [] },
						taskItemEditId : -1, 
						followupEditId : -1,
						editMode : 'details', 
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

				this.task = { title : '', task_items : [], followups : [] };

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

						alertSuccess( ___t('Saved.') );

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
							vm.task = { title : '', task_items : [], followups : [] };

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

		refresh : function () {

			vm.$forceUpdate();

		}

	},

	mounted() {

		// Get task and details
		this.fetchTask();

	},

});
