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
//Route::get('/user/{user_id?}', function(){
//    return view('userTasks');
//});
Route::get('/', 'IndexController@renderView');
Route::delete('/user/destroy/{user_id?}', 'UserController@destroy');
Route::get('/users', 'IndexController@index');
Route::get('/users/edit/{user_id?}', 'UserController@editView');
Route::get('usersEdit/{id?}', 'UserController@edit');
Route::put('/users/update/{user_id?}', 'UserController@update');
Route::post('/users/add_user', 'UserController@store');
Route::get('usersData/{id?}', 'UserController@getTasksByUserId');
Route::get('/users/destroy/{user_id?}', 'UserController@destroy');

Route::get('/tasksAll', 'TaskController@index');
Route::get('/tasks', 'TaskController@tasksView');
Route::delete('/tasks/destroy/{task_id?}', 'TaskController@destroy');
Route::post('/tasks/add_task', 'TaskController@store');
Route::get('/tasks/edit/{task_id?}', 'TaskController@editView');
Route::get('/tasksEdit/{id?}', 'TaskController@show');
Route::put('/tasks/update/{task_id?}', 'TaskController@update');
Route::get('/users/{user_id?}', 'UserController@show');