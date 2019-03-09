<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    protected $fillable = [
        'name', 'description', 'start_date', 'end_date', 'count'
    ];

//    public function difficulty() {
//        return $this->belongsTo(TaskDifficulty::class);
//    }

//    public function status() {
//        return $this->belongsTo(TaskStatus::class);
//    }

    public function comments()
    {
        return $this->belongsToMany(User::class, 'task_comments');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function taskStatus()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function isStatus($check)
    {
        return $this->taskStatus->name == $check;
    }

    public static function allTasksForCompany(Company $company, $opts = [])
    {
        $tasks = $company
            ->users
            ->load(['tasks' => function($query) use ($opts) {
                if(isset($opts['year'])) {
                    $query->whereRaw("YEAR(start_date) = ?", array($opts['year']));
                }

                if(isset($opts['month'])) {
                    $query->whereRaw("MONTH(start_date) = ?", array($opts['month']));
                }
            }, 'tasks.taskStatus'])
            ->map(function($employee) { return $employee->tasks; } )
            ->flatten();

        return $tasks;
    }
}
