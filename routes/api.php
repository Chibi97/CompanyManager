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


Route::get('/users/', 'Authentication\Api\UserController@index');
Route::get('/users/{user}', 'Authentication\Api\UserController@show');
Route::post('/users', 'Authentication\Api\UserController@store');
Route::put('/users/{user}', 'Authentication\Api\UserController@update');

