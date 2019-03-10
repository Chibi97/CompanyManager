<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
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

    public static function getStartYearsForTasks(Company $company)
    {
        $years = $company->users
            ->load('tasks')->pluck('tasks')
            ->flatten()->pluck('start_date')
            ->map(function($y) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $y)->year;
            })
            ->unique()
            ->toArray();

        rsort($years);
        if(empty($years)) {
            $years[0] = Carbon::now()->year;
        }
        return $years;
    }

    public static function allTasksForCompany(Company $company, $opts = [])
    {
        $years = self::getStartYearsForTasks($company);

        $tasks = $company
            ->users
            ->load(['tasks' => function($query) use ($opts, $years) {
                $year = $opts['year'] ?? $years[0];
                $query->whereRaw("YEAR(start_date) = ?", array($year));

                if(isset($opts['month'])) {
                    if($opts['month'] != 0) {
                        $query->whereRaw("MONTH(start_date) = ?", array($opts['month']));
                    }
                }
            }, 'tasks.taskStatus'])
            ->map(function($employee) { return $employee->tasks; } )
            ->flatten();

        return $tasks;
    }

}
