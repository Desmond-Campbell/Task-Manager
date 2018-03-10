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
