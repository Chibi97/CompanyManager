<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Helpers\UserTaskHelper;

class UserTaskController extends Controller
{

    protected $helper;
    public function __construct(UserTaskHelper $helper)
    {
        $this->helper = $helper;
        $this->middleware("CheckApiToken");
    }

    public function pendingTasks()
    {
        $pending = $this->helper->getPendingTasks();
        return response($pending, 200);
    }

    public function getTasks()
    {
        $tasks = $this->helper->getUserTasks();
        return response($tasks, 200);
    }

    public function availableTasks()
    {
        $tasks = $this->helper->getAvailableTasks();
        return response($tasks, 200);
    }

}