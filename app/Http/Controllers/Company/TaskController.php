<?php

namespace App\Http\Controllers\Company;

use App\Http\Helpers\TaskHelper;
use App\Models\Task;
use App\Models\TaskPriority;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class TaskController extends Controller
{
    public $defaultDate;
    protected $priorities;
    protected $user;

    public function __construct()
    {
        $this->defaultDate = Carbon::now()->format('Y-m-d\TH:i');
        $this->priorities = TaskPriority::all()->pluck('name');
        $this->middleware('Before')->except('index', 'create');
    }

    public function before(Request $request)
    {
        $this->user = session()->get('user');
        $this->user->refresh();
        $company = $this->user->company;

        if($employees = $request->input('employees')) {
            return $company->canCompanyManageTask($employees);
        }
        if($task = $request->route('task')) {
            return $task->isTaskFromCompany($company);
        }
    }

    public function index()
    {
        $tasks = session()->get('user')
                 ->company->users
                 ->each(function ($elem) {
                     $elem->tasks;
                 })->load('tasks.taskPriority', 'tasks.taskStatus','tasks.users')
                 ->pluck('tasks')
                 ->flatten()
                 ->unique('id');

        $user = session()->get('user');
        $token = $user->company->api_token;

        return view('company.tasks.index', compact('tasks', 'token'));

    }


    public function create()
    {
        $user = session()->get('user');
        $employees = $user->getUserNames();
        $token = $user->company->api_token;
        $defaultDate = $this->defaultDate;
        $priorities = $this->priorities;
        $label = "Add";
        return view('company.tasks.create', compact( 'priorities','defaultDate', 'employees', 'token', 'label'));
    }

    public function edit(Task $task, TaskHelper $helper)
    {
        $employees = $this->user->getUserNames();
        $token = $this->user->company->api_token;
        $defaultDate = $this->defaultDate;
        $priorities = $this->priorities;
        $task = $helper->show($task);
        $label = "Update";

        $startDateFormatted = Carbon::make($task->start_date)->format('Y-m-d\TH:i');
        $endDateFormatted = Carbon::make($task->end_date)->format('Y-m-d\TH:i');

        return view('company.tasks.edit', compact('task','defaultDate', 'employees', 'priorities', 'token', 'startDateFormatted','endDateFormatted', 'label'));
    }


}
