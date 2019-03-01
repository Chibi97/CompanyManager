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
    return view('dashboard');
})->name('home');


Route::get('/my-tasks', function () {
    return view('employee.my_tasks');
})->name('my-tasks');


Route::get('/all-tasks', function () {
    return view('employee.all_tasks');
})->name('all-tasks');









