<?php

date_default_timezone_set('America/Jamaica');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'TaskController@browseWorking');
Route::get('/home', function(){ return redirect('/'); })->name('home');

Route::get('/dashboard', 'TaskController@index');

Route::get('/new', 'TaskController@edit');
Route::get('/edit/{id}', 'TaskController@edit');

Route::get('/browse/working', 'TaskController@browseWorking');
Route::get('/browse/late', 'TaskController@browseLate');
Route::get('/browse/due/{when}', 'TaskController@browseDue');
Route::get('/browse/pipeline/{when}', 'TaskController@browsePipeline');
Route::get('/browse/followups/{when}', 'TaskController@browseFollowups');

Route::post('/api/tasks/working', 'TaskController@apiBrowseWorking');
Route::post('/api/tasks/working/{when}', 'TaskController@apiBrowseWorking');
Route::post('/api/tasks/late', 'TaskController@apiBrowseLate');
Route::post('/api/tasks/late/{when}', 'TaskController@apiBrowseLate');
Route::post('/api/tasks/due/{when}', 'TaskController@apiBrowseDue');
Route::post('/api/tasks/pipeline/{when}', 'TaskController@apiBrowsePipeline');
Route::post('/api/tasks/followups/{when}', 'TaskController@apiBrowseFollowups');

Route::get('/api/tasks/{id}/get', 'TaskController@getTask');
Route::post('/api/tasks/{id}/update', 'TaskController@updateTask');
Route::post('/api/tasks/{id}/save-notes', 'TaskController@saveTaskNotes');
Route::post('/api/tasks/{id}/parse-items-bulk', 'TaskController@parseBulkItems');
Route::delete('/api/tasks/{id}/delete', 'TaskController@deleteTask');

Route::post('/api/tasks/{id}/action', 'TaskController@action');

Route::get('/search/{query}', 'TaskController@search');
Route::post('/search/{query}', 'TaskController@search');
Route::get('/search', 'TaskController@searchResults');

Route::get('/indx', function(){

	\App\SearchIndex::rebuildIndex( 0, 1000 );

	if ( request('return') ) {

		return redirect( base64_decode( request('return') ) );

	} else {

		return redirect( '/search' );

	}

});
