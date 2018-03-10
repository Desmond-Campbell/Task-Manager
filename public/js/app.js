function ___t( text ) {

	return text;

}

function alertError( error ) {

	alert( error );

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
