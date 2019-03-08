<?php

namespace App\Http\Controllers\Company;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function stats(Request $request) {
        $months = [];
        foreach(range(1,12) as $month_num) {
            $months[] = Carbon::create(2019, $month_num, 1, 0, 0, 0)
                        ->format("F");
        }

        $user = session()->get('user');

        $tasks = Task::allTasksForCompany($user->company);
        $years = [];
        foreach($tasks->pluck('start_date') as $date) {
            $years[] = (new Carbon($date))->format('Y');
        }
        $years = array_unique($years);

        //$builder = session()->get('user')->tasks;

        if($request->get('selectMnt') || $request->get('selectYr')) {
            $month = $request->get('selectMnt');
            $year  = $request->get('selectYr');
        }

        return view('company.stats', compact("months", "years"));
    }

}
