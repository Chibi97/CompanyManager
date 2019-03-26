<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getAllMonths()
    {
        $months = [];
        $months[] = "All";
        foreach(range(1,12) as $month_num) {
            $months[] = Carbon::create(2019, $month_num, 1, 0, 0, 0)
                ->format("F");
        }

        return $months;
    }
}
