<?php

namespace App\Http\Helpers;

use App\Models\TaskStatus;

class Dashboard
{
    public function stats($tasks)
    {
        $statuses = TaskStatus::all()->take(4);

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

        return $stats;
    }
}