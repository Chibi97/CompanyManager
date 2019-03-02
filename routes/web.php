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

Route::get('/', 'FrontController@index')->name('job-offers');

Route::get('/register', 'Authentication\UserController@create')->name('register');
Route::get('/login', 'Authentication\LoginController@create')->name('login');

// E M P L O Y E E
Route::get('/employee', function () {
    return view('employee.dashboard');
})->name('employee_dashboard');

Route::get('/employee/my-tasks', function () {
    return view('employee.my_tasks');
})->name('my-tasks');


Route::get('/employee/all-tasks', function () {
    return view('employee.all_tasks');
})->name('all-tasks');











