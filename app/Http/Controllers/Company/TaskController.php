<?php

namespace App\Http\Controllers\Company;

use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware("Before");
    }

    public function before()
    {
        $user = session()->get('user');
        $user->refresh();
        $users = $user->company->users;
        $result = $users->whereIn('id', $user->id);
        return $result->isNotEmpty();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $priorities = TaskPriority::all()->pluck('name');
        $user = session()->get('user');
        $employees = $user->getUserNames();
        return view('company.tasks', compact('priorities', 'employees'));
    }

    /**
     * StoreUsers a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
