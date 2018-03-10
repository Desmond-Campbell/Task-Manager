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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/new', 'TaskController@edit');
Route::get('/edit/{id}', 'TaskController@edit');

Route::get('/api/tasks/{id}/get', 'TaskController@getTask');
Route::post('/api/tasks/{id}/update', 'TaskController@updateTask');
Route::delete('/api/tasks/{id}/delete', 'TaskController@deleteTask');
