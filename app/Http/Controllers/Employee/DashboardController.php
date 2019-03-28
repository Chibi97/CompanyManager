<?php

namespace App\Http\Controllers\Employee;

use App\Http\Helpers\Dashboard;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    protected $helper;
    protected $user;

    public function __construct(Dashboard $helper)
    {
        $this->helper = $helper;
        $this->middleware('Before');
    }

    public function before()
    {
        $this->user = session()->get('user');
        $this->user->refresh();
        return true;
    }

    public function stats(Request $request)
    {
        $years = Task::getEmployeeTasksYears($this->user);
        $months = parent::getAllMonths();
        $month = $request->query('month') ?? 0;
        $year = $request->query('year') ?? $years[0];

        $tasks = Task::employeeTasks($this->user, $request->query());
        $stats = $this->helper->stats($tasks);
        $pending = $this->pendingTasks();

        return view('employee.stats', compact('stats', 'years', 'months', 'year', 'month', 'pending'));
    }


    public function pendingTasks()
    {
        return $this->user->tasks()->wherePivot('is_accepted','=', 0)->get();
    }

}
