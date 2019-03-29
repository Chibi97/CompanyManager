<?php

namespace App\Http\Controllers\Employee;

use App\Http\Helpers\UserTaskHelper;
use App\Http\Controllers\Controller;
use App\Models\TaskStatus;

class TaskController extends Controller
{
    protected $helper;

    public function __construct(UserTaskHelper $helper)
    {
        $this->helper = $helper;
    }

    public function myTasks()
    {
        $tasks = $this->helper->getUserTasks();
        $statuses = TaskStatus::take(4)->pluck('name','id');
        return view('employee.my_tasks', compact('tasks', 'statuses'));
    }

    public function tasks() {
        return view('employee.tasks');
    }

}
