<?php

namespace App\Http\Controllers\Company;

use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class TaskController extends Controller
{

    public function index()
    {
    }


    public function create()
    {
        $priorities = TaskPriority::all()->pluck('name');
        $user = session()->get('user');
        $employees = $user->getUserNames();
        $defaultDate = Carbon::now()->format('Y-m-d\TH:i');
        $token = $user->company->api_token;
        return view('company.tasks', compact('priorities', 'employees', 'defaultDate', 'token'));
    }


    public function store(Request $request)
    {
        //
    }

    public function show(Task $task)
    {
        //
    }


    public function edit(Task $task)
    {
        //
    }


    public function update(Request $request, Task $task)
    {
        //
    }

    public function destroy(Task $task)
    {
        //
    }
}
