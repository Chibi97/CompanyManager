<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::resource('/users', 'Api\UserController');
Route::put('/users/{user}/promote', 'Api\UserController@promote');
Route::put('/users/{user}/demote', 'Api\UserController@demote');
Route::post('/auth','Api\UserController@login');

Route::resource('/tasks', 'Api\TaskController')->except(['create','edit']);
Route::put('/tasks/{task}/accept', 'Api\TaskController@acceptTask');
Route::put('/tasks/{task}/deny', 'Api\TaskController@denyTask');

Route::get('/task-priorities', 'Api\TaskPriorityController@index');

Route::group(['prefix' => '/user/tasks'], function() {
    Route::get('/', 'Api\UserTaskController@pendingTasks');
    Route::get('/pending', 'Api\UserTaskController@index');
    Route::get('/available', 'Api\UserTaskController@index');
});

Route::fallback( function() {
    return response()->json(['message' => 'Resource not found'], 404);
});


//Route::get('/tasks/', 'Api\TaskController@index');
//Route::get('/tasks/{task}', 'Api\TaskController@show');
//Route::post('/tasks', 'Api\TaskController@store');
//Route::put('/tasks/{task}', 'Api\TaskController@update');
//Route::delete('/tasks/{task}', 'Api\TaskController@destroy');

//Route::get('/users', 'Api\UserController@index');
//Route::get('/users/{user}', 'Api\UserController@show');
//Route::post('/users', 'Api\UserController@store');
//Route::put('/users/{user}', 'Api\UserController@update');
//Route::delete('/users/{user}', 'Api\UserController@destroy');