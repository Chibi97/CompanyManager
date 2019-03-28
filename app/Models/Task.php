<?php

namespace App\Models;

use App\Models\DTOs\TaskDTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Task extends Model
{
    use SoftDeletes;

    private $model;

    public function setModel(TaskDTO $task)
    {
        $this->model = $task;
    }

    protected $fillable = [
        'name', 'description','count', 'start_date', 'end_date'
    ];


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

    public function taskPriority() {
        return $this->belongsTo(TaskPriority::class);
    }

    public function isStatus($check)
    {
        return $this->taskStatus->name == $check;
    }

    public function isTaskFromCompany(Company $company)
    {
        $taskUsers = $this->users;
        $result = $taskUsers->map(function ($user) use ($company) {
            if($user->company->id == $company->id) {
                return true;
            } else return false;
        });

       return $result->contains(true);
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

    public static function dueDateTasks(Company $company)
    {
        $tasks = $company->users
            ->load(['tasks', 'tasks.taskPriority', 'tasks.taskStatus', 'tasks.users'])
            ->pluck('tasks')
            ->flatten()
            ->map(function($task) {
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $task->end_date);
                $now  = Carbon::now('Europe/Belgrade');
                if($date->diffInDays($now) <= 10 && !$date->isPast()) {
                    $value = $date->diffInDays($now) == 1 ? "1 day" : $date->diffInDays($now) . " days";
                    $task->setAttribute('daysLeft', $value);
                    return $task;
                }
            })
            ->flatten()->unique()
            ->filter(function ($value) {
                return $value != null;
            });


        return $tasks;
    }

    public static function filterTasksByStartDate(Company $company, $opts = [])
    {
        $years = self::getStartYearsForTasks($company);

        $tasks = $company
            ->users
            ->each(function ($elem) {
                $elem->tasks;
            })
            ->load(['tasks' => function($query) use ($opts, $years) {
                $year = $opts['year'] ?? $years[0];
                $query->whereRaw("YEAR(start_date) = ?", array($year));

                if(isset($opts['month'])) {
                    if($opts['month'] != 0) {
                        $query->whereRaw("MONTH(start_date) = ?", array($opts['month']));
                    }
                }
            }, 'tasks.taskStatus', 'tasks.taskPriority', 'tasks.users'])
            ->pluck('tasks')
            ->flatten()
            ->unique('id');

        return $tasks;
    }

    public static function getEmployeeTasksYears($user)
    {
        $years = $user->tasks->pluck('start_date')
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

    public static function employeeTasks($user, $opts = [])
    {

        $years = self::getEmployeeTasksYears($user);
        $tasks = $user
            ->load(['tasks' => function($query) use ($opts, $years) {
                $year = $opts['year'] ?? $years[0];
                $query->whereRaw("YEAR(start_date) = ?", array($year));

                if(isset($opts['month'])) {
                    if($opts['month'] != 0) {
                        $query->whereRaw("MONTH(start_date) = ?", array($opts['month']));
                    }
                }
            }, 'tasks.taskStatus'])
            ->tasks
            ->unique('id');

        return $tasks;
    }

    public static function storeTask($name, $description, $start, $end, $numOfEmployees, $priority, $employees)
    {
        DB::beginTransaction();
        try {
            $task = Task::make([
                'name' => $name,
                'description' => $description,
                'start_date' => $start,
                'end_date' => $end,
                'count' => $numOfEmployees
            ]);

            $status = TaskStatus::where('name', 'On hold')->first();
            $priority = TaskPriority::where('name', $priority)->first();
            $task->taskStatus()->associate($status);
            $task->taskPriority()->associate($priority);

            $task->save();

            $task->users()->attach($employees,
                [
                    "is_accepted" => 0,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                ]);

        } catch(QueryException $e) {
            DB::rollBack();
            throw new BadRequestHttpException();
        }

        DB::commit();
    }

    public function updateTask($data)
    {
        DB::transaction(function() use ($data) {

            if(isset($data['status'])) {
                try {
                    $status = TaskStatus::where('name', $data['status'])->first();
                    $this->taskStatus()->associate($status);
                } catch(QueryException $e) {
                    throw new BadRequestHttpException();
                }
            }

            if(isset($data['priority'])) {
                try {
                    $priority = TaskPriority::where('name', $data['priority'])->first();
                    $this->taskPriority()->associate($priority);
                } catch(QueryException $e) {
                    throw new BadRequestHttpException();
                }
            }

            $this->fill($data);
            $this->save();

            if(isset($data['employees'])) {
                $assignedUsers = $this->users->pluck('id');
                $syncArr = [];
                foreach($data['employees'] as $employee) {
                    if($assignedUsers->contains($employee)) {
                        $exist = User::find($employee);
                        foreach($exist->tasks as $task) {
                            $syncArr[$employee] = ['is_accepted' => $task->pivot->is_accepted,
                                'created_at' => $task->pivot->created_at,
                                'updated_at' => Carbon::now()
                            ];
                        }
                    } else {
                        $syncArr[$employee] = ['is_accepted' => 0,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];
                    }
                }
                 $this->users()->sync($syncArr);
            }
        });
    }

    public function deleteTask()
    {
        DB::transaction(function() {
            // $this->users()->detach();  TODO: VRATITI OVO U PRODUKCIJI
            $this->delete();
        });
    }

}
