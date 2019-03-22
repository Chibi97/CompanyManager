<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\TaskPriority;
use App\Http\Controllers\Controller;

class TaskPriorityController extends Controller
{
    public function index() {
        return TaskPriority::all();
    }
}
