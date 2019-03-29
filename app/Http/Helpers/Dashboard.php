<?php

namespace App\Http\Helpers;

use App\Models\TaskStatus;

class Dashboard
{
    public function stats($tasks, $param = null)
    {
        $takeNum = 4;
        if($param == 'deny') {
            $takeNum = 5;
        }
        $statuses = TaskStatus::all()->take($takeNum);

        $stats = [];
        $icons = [
            'far fa-check-square',
            'far fa-clock',
            'fas fa-pause',
            'fas fa-hourglass-end'
        ];
        if($param == 'deny') {
            $icons[] = 'fas fa-user-times';
        }

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
        return $stats;
    }
}