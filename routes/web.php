<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
//Route::get('/tasks', 'Employee\TaskController@tasks')->name('employee.tasks');

|
*/

Route::get('/', 'FrontController@home')->name('job.offers');
Route::get('/logout', 'Authentication\LoginController@destroy')->name('logout');
Route::get('/whoami', 'Authentication\LoginController@whoami');

Route::group(['middleware'=> 'RedirectIfLogin'],function() {
    Route::post('/login', 'Authentication\LoginController@store')->name('login');
    Route::get('/login', 'Authentication\LoginController@create')->name('login.form');
    Route::post('/register', 'Authentication\RegisterController@store')->name('register');
    Route::get('/register', 'Authentication\RegisterController@create')->name('register.form');
});

// E M P L O Y E E
Route::group(['middleware' => 'MyAuth:employee', 'prefix' => 'employee'], function () {
    Route::get('/', 'Employee\DashboardController@stats')->name('employee.dashboard');
    Route::get('/my-tasks', 'Employee\TaskController@myTasks')->name('employee.my-tasks');
});

// B O S S
Route::group(['middleware' => 'MyAuth:boss', 'prefix' => 'company'], function() {
    Route::get('/', 'Company\DashboardController@stats')->name('company.dashboard');
    Route::resource('/users', 'Company\UserController')->only(['index', 'update', 'destroy']);
    Route::resource('/tasks', 'Company\TaskController');
});

/*
 *   uri                     |  method    | name for the route  |  verb
 *
 *   company/tasks           |  index()   | tasks.index         |  GET
 *   company/tasks/create    |  create()  | tasks.create        |  GET
 *   company/tasks/{id}      |  show()    | tasks.show          |  GET
 *   company/tasks/{id}/edit |  edit()    | tasks.edit          |  GET
 *   company/tasks           |  store()   | tasks.store         |  POST
 *   company/tasks/{id}      |  update()  | tasks.update        |  PUT / PATCH
 *   company/tasks/{id}      |  destroy() | tasks.destroy       |  DELETE
 *
 */










