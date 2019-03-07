<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function stats(Request $request) {
        $months = [];
        foreach(range(1,12) as $month_num) {
            $months[] = Carbon::create(2018, $month_num, 1, 0, 0, 0)->format("F");
        }

        $builder = session()->get('user')->tasks;
        //dd($builder);

        if($request->get('selectMnt') || $request->get('selectYr')) {
            $month = $request->get('selectMnt');
            $year  = $request->get('selectYr');
        }


        return view('company.stats', compact("months"));
    }

}
