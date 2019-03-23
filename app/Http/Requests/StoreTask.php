<?php

namespace App\Http\Requests;


class StoreTask extends StoreTasksRequest
{
    protected function rulesOverrides()
    {
        return [
            'name' => ["required"],
            'description' => ["required"],
            'start_date' => ["required", "before_or_equal:end_date"],
            'end_date' => ["required", "after_or_equal:start_date"],
            'count' => ["required"],
            'priority' => ["required"],
            'employees' => ["required"],
            'employees.*' => ["required"]
        ];
    }

    public function messagesOverrides()
    {
        return [];
    }

}
