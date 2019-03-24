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


Route::get('/users', 'Api\UserController@index');
Route::get('/users/{user}', 'Api\UserController@show');
Route::post('/users', 'Api\UserController@store');
Route::put('/users/{user}', 'Api\UserController@update');
Route::put('/users/{user}/promote', 'Api\UserController@promote');
Route::put('/users/{user}/demote', 'Api\UserController@demote');
Route::delete('/users/{user}', 'Api\UserController@destroy');

Route::get('/tasks/', 'Api\TaskController@index');
Route::get('/tasks/{task}', 'Api\TaskController@show');
Route::post('/tasks', 'Api\TaskController@store');
Route::put('/tasks/{task}', 'Api\TaskController@update');
Route::delete('/tasks/{task}', 'Api\TaskController@destroy')->name('api.tasks.destroy');

Route::get('/task-priorities', 'Api\TaskPriorityController@index');

Route::post('/auth','Api\UserController@login');

Route::fallback( function() {
    return response()->json(['message' => 'Resource not found'], 404);
});
