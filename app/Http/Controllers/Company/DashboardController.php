<?php

namespace App\Http\Controllers\Company;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function stats(Request $request)
    {
        $months = parent::getAllMonths();
        $month = $request->query('month') ?? 0;

        $user = session()->get('user');
        $user->refresh();

        $tasks = Task::allTasksForCompany($user->company, $request->query());
        $statuses = TaskStatus::all()->take(4); // TODO: maybe to scope this to company

        $stats = [];
        $icons = [
            'far fa-check-square',
            'far fa-clock',
            'fas fa-pause',
            'fas fa-hourglass-end'
        ];

        foreach ($statuses as $index => $status) {
            $stats[$status->name] = [
                'count' => 0,
                'css' => 'overview-item--c' . ($index+1),
                'icon' => $icons[$index]
            ];
        }

        foreach ($statuses as $status) {
            foreach ($tasks as $task) {
                if($task->isStatus($status->name)) {
                    $stats[$status->name]['count']++;
                }
            }
        }

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
