<?php

namespace App\Http\Controllers\Company;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function stats(Request $request) {
        $months = [];
        foreach(range(1,12) as $month_num) {
            $months[] = Carbon::create(2019, $month_num, 1, 0, 0, 0)
                        ->format("F");
        }

        $year  = $request->query('year')  ?? Carbon::now()->year;
        $month = $request->query('month') ?? 1;

        $user = session()->get('user');
        $user->refresh();

        $tasks = Task::allTasksForCompany($user->company, $request->query());
        $statuses = TaskStatus::all()->take(4); // TODO: need to scope this to company

        $stats = [];
        $icons = [
            'far fa-clock',
            'far fa-check-square',
            'fas fa-pause',
            'fas fa-user-times'
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

        $startDates = Task::allTasksForCompany($user->company)->pluck('start_date');
        $years = [];
        foreach($startDates as $date) {
            $years[] = (new Carbon($date))->format('Y');
        }
        $years = array_unique($years);
        rsort($years);

        return view('company.stats', compact("months", "years", "stats", "year", "month"));
    }

}
