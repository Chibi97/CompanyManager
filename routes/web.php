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
Route::get('/employee', 'Employee\DashboardController@stats')->name('employee.dashboard');
Route::get('/employee/tasks', 'Employee\TaskController@allTasks')->name('employee.tasks');
Route::get('/employee/my-tasks', 'Employee\TaskController@myTasks')->name('employee.my-tasks');

// B O S S
Route::get('/company', 'Company\DashboardController@stats')->name('company.dashboard');
Route::get('/company/tasks', 'Company\TaskController@index')->name('company.tasks');
Route::get('/company/tasks/create', 'Company\TaskController@create')->name('company.tasks.create');
/*
 *   uri              |  method    | name for the route  |  verb
 *
 *   /tasks           |  index()   | tasks.index         |  GET
 *   /tasks/create    |  create()  | tasks.create        |  GET
 *   /tasks/{id}      |  show()    | tasks.show          |  GET
 *   /tasks/{id}/edit |  edit()    | tasks.edit          |  GET
 *   /tasks           |  store()   | tasks.store         |  POST
 *   /tasks/{id}      |  update()  | tasks.update        |  PUT
 *   /tasks/{id}      |  destroy() | tasks.destroy       |  DELETE
 *
 *   Route::resource('tasks', 'Company\TaskController');
 */









