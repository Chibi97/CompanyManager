<?php

namespace App\Http\Requests;


class StoreTask extends StoreTasksRequest
{
    protected function rulesOverrides()
    {
        return [
            'name' => ["required"],
            'description' => ["required"],
            'start_date' => ["required"],
            'end_date' => ["required"],
            'count' => ["required"],
            'priority' => ["required"],
            'employees' => ["required"],
            'employees.*' => ["required"]
        ];
    }

}
