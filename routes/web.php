<?php

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

Route::get('/', 'TaskController@index');
Route::get('/home', function(){ return redirect('/'); })->name('home');

Route::get('/new', 'TaskController@edit');
Route::get('/edit/{id}', 'TaskController@edit');

Route::get('/browse/late', 'TaskController@browseLate');
Route::get('/browse/due/{when}', 'TaskController@browseDue');
Route::get('/browse/pipeline/{when}', 'TaskController@browsePipeline');
Route::get('/browse/followups/{when}', 'TaskController@browseFollowups');

Route::post('/api/tasks/late', 'TaskController@apiBrowseLate');
Route::post('/api/tasks/late/{when}', 'TaskController@apiBrowseLate');
Route::post('/api/tasks/due/{when}', 'TaskController@apiBrowseDue');
Route::post('/api/tasks/pipeline/{when}', 'TaskController@apiBrowsePipeline');
Route::post('/api/tasks/followups/{when}', 'TaskController@apiBrowseFollowups');

Route::get('/api/tasks/{id}/get', 'TaskController@getTask');
Route::post('/api/tasks/{id}/update', 'TaskController@updateTask');
Route::delete('/api/tasks/{id}/delete', 'TaskController@deleteTask');

Route::post('/api/tasks/{id}/action', 'TaskController@action');
