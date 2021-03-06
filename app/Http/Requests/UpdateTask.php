<?php

namespace App\Http\Requests;



use App\Models\Task;
use App\Models\TaskStatus;

class UpdateTask extends StoreTasksRequest
{
    protected function rulesOverrides()
    {
        $rules = [];

        $statuses = TaskStatus::take(4)->pluck('name');
        foreach($statuses as $p) {
            $statuses[] = strtolower($p);
        }
        $statuses = $statuses->implode('|');
        $regex = "/^$statuses$/";

        $rules['status'] = ["sometimes", "min:2", "max:30","regex:$regex"];
        $rules['name'] = ["sometimes"];
        $rules['description'] = ["sometimes"];
        $rules['description'] = ["sometimes"];
        $rules['count'] = ["sometimes"];
        $rules['priority'] = ["sometimes"];
        $rules['employees'] = ["sometimes"];

        $taskId = $this->route('task')->id;

        if($this->input('end_date') && !$this->input('start_date')) {
            $rules['end_date'] = ["after_or_equal:" . Task::find($taskId)->start_date];
        } else {
            $rules['end_date'] = ["after_or_equal:start_date"];
        }

        if($this->input('start_date') && !$this->input('end_date')) {
            $rules['start_date'] = ["before_or_equal:" . Task::find($taskId)->end_date];
        } else {
            $rules['start_date'] = ["before_or_equal:end_date"];
        }

        return $rules;
    }

    public function messagesOverrides()
    {
        $statuses = TaskStatus::all()->pluck('name')->implode(', ');

        return [
            "status.regex" => "Status should be one of these: $statuses"
        ];
    }
}
