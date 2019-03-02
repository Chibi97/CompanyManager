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

Route::get('/', 'FrontController@home')->name('job-offers');

Route::get('/register', 'Authentication\UserController@index')->name('register-form');
Route::get('/login', 'Authentication\LoginController@index')->name('login-form');

// E M P L O Y E E
Route::get('/employee/statistics', 'Employee\DashboardController@stats')->name('employee.dashboard');
Route::get('/employee/tasks', 'Employee\TaskController@tasks')->name('employee.tasks');
Route::get('/employee/my-tasks', 'Employee\TaskController@myTasks')->name('employee.my-tasks');

// B O S S
Route::get('/company/statistics', 'Company\DashboardController@stats')->name('company.dashboard');
Route::resource('company/tasks', 'Company\TaskController');
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









