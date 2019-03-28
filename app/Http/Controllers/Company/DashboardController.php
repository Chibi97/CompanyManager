<?php

namespace App\Http\Controllers\Company;

use App\Http\Helpers\Dashboard;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    protected $helper;

    public function __construct(Dashboard $helper)
    {
        $this->helper = $helper;
    }

    public function stats(Request $request)
    {
        $months = parent::getAllMonths();
        $month = $request->query('month') ?? 0;

        $user = session()->get('user')->refresh();

        $tasks = Task::allTasksForCompany($user->company, $request->query());
        $stats = $this->helper->stats($tasks);

        $years = Task::getStartYearsForTasks($user->company);
        $year  = $request->query('year') ?? $years[0];
        $dueDateTasks = $this->showDueDateTasks();

        return view('company.stats',
            compact("months", "years", "stats", "year", "month", "dueDateTasks"));
    }

    public function showDueDateTasks()
    {
        $user = session()->get('user');
        $user->refresh();
        $tasks = Task::dueDateTasks($user->company);
        return $tasks;
    }

}
