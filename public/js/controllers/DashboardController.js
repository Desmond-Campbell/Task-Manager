var vm = new Vue({

	el : '#DashboardController',
	
	data : { 
						period : 'today',
						tasks : [ { due : [], late : [], pipeline : [], followup : [] } ],
						columns : [ 'due', 'late', 'pipeline', 'followups' ],
						// mode : 'due',
						sort : { field : 'priority', order : 'asc', show_completed : false, limit : 5 } 
					},
	
	methods : {

		fetchTasks : function () {

			for ( i = 0; i < vm.columns.length; i++ ) {

				mode = vm.columns[i];

				axios.post( '/api/tasks/' + mode + '/' + this.period, { sort : this.sort } ).then( 

					function ( response ) {

						vm.tasks[response.data.mode] = response.data.tasks;
						vm.refresh();

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

		},

	},

	mounted() {

	},

});
