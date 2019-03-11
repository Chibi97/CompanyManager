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

Route::group(['middleware' => ['CheckApiToken']], function () {
//     If company token is acquired through headers, then proceed to these actions
    Route::get('/users/', 'Authentication\Api\UserController@index');
    Route::get('/users/{user}', 'Authentication\Api\UserController@show');
    Route::post('/users', 'Authentication\Api\UserController@store');
    Route::put('/users/{user}', 'Authentication\Api\UserController@update');
});
