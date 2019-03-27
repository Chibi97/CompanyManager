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
        if($task = $request->route('task')) {
            return $task->isTaskFromCompany($company);
        }
    }

    public function index(Request $request)
    {
        $user = session()->get('user')->refresh();
        $company = $user->company;
        $tasks = Task::filterTasksByStartDate($company, $request->query());

        $years = Task::getStartYearsForTasks($company);
        $year  = $request->query('year') ?? $years[0];

        $months = parent::getAllMonths();
        $month = $request->query('month') ?? 0;

        return view('company.tasks.index', compact('tasks', 'years', 'year', 'months', 'month'));
    }


    public function create()
    {
        $user = session()->get('user')->refresh();
        $employees = $user->getUserNames();
        $defaultDate = $this->defaultDate;
        $priorities = $this->priorities;
        $label = "Add";
        return view('company.tasks.create', compact( 'priorities','defaultDate', 'employees','label'));
    }

    public function edit(Task $task, TaskHelper $helper)
    {
        $task = $helper->show($task);
        $employees = $this->user->getUserNames();
        $defaultDate = $this->defaultDate;
        $priorities = $this->priorities;
        $label = "Update";

        $startDateFormatted = Carbon::make($task->start_date)->format('Y-m-d\TH:i');
        $endDateFormatted = Carbon::make($task->end_date)->format('Y-m-d\TH:i');

        return view('company.tasks.edit', compact('task','defaultDate', 'employees',
            'priorities', 'startDateFormatted','endDateFormatted', 'label'));
    }


}
