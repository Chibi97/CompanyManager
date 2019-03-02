<?php

namespace App\Http\Controllers\Employee;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function myTasks()
    {
        return view('employee.my_tasks');
    }

    public function tasks() {
        return view('employee.tasks');
    }




}
