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
            });
        $years = json_decode(json_encode($years), false);
        $years = array_unique($years);
        rsort($years);
        return $years;
    }

    public static function allTasksForCompany(Company $company, $opts = [])
    {
        $years = self::getStartYearsForTasks($company);
        if(empty($years)) {
            $years[0] = Carbon::now()->year;
        }

        $tasks = $company
            ->users
            ->load(['tasks' => function($query) use ($opts, $years) {
                if(isset($opts['year'])) {
                    $query->whereRaw("YEAR(start_date) = ?", array($opts['year']));
                } else $query->whereRaw("YEAR(start_date) = ?", $years[0]);

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
