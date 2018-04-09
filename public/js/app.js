function ___t( text ) {

	return text;

}

function alertError( error ) {

    alert( error );

}

function alertSuccess( message ) {

    alert( message );

}

function alertConfirm( message ) {

	return confirm( message );

}

var general_error = ___t( 'We could not submit your request due to a general error. Please refresh and try again. If you are still unsuccessful, kindly contact Support.' );

var general_error_failure = ___t( 'We are currently experience a system problem. Please refresh and try again. If you are still unsuccessful, kindly contact Support.' );

Array.prototype.move = function (old_index, new_index) {
    if (new_index >= this.length) {
        var k = new_index - this.length;
        while ((k--) + 1) {
            this.push(undefined);
        }
    }
    this.splice(new_index, 0, this.splice(old_index, 1)[0]);
    return this; // for testing purposes
};

/******* Nav Controller *********/

var nav = new Vue({

  el : '#NavController',
  
  data : { 

            params : { start_date : null, period : 'sunday', offset : 0 },
            tasks : [],
            days : [ ___t('Sunday'), ___t('Monday'), ___t('Tuesday'), ___t('Wednesday'), ___t('Thursday'), ___t('Friday'), ___t('Saturday') ],
            days_short : [ ___t('S'), ___t('M'), ___t('T'), ___t('W'), ___t('T'), ___t('F'), ___t('S') ],
            hours : [ /*0, 1, 2, 3, 4,*/ 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23 ],
            showSchedule :false,
            schedule_dates : []

          },
  
  methods : {

    toggleSchedule : function () {

      this.showSchedule = !this.showSchedule;

    },

    reset : function () {

      this.params.offset = 0;
      this.getSchedule(0);

    },

    getSchedule : function ( offset ) {

      this.params.offset += offset;

      axios.post( '/api/tasks/get-schedule', this.params ).then( 

        function ( response ) {

          nav.tasks = response.data.tasks;
          nav.schedule_dates = response.data.dates;

        },

        function () {

          alertError( general_error_failure );

        }

      );

    },

    /****************/

    refresh : function () {

      nav.$forceUpdate();

    }

  },

  mounted() {

    this.getSchedule(0);

  },

  filters : {
    moment: function (date, format) {
      return moment(date).format(format);
    }
  }


});
