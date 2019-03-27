<?php

namespace App\Models;

use App\Http\Helpers\CompanyManager;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        "name"
    ];

    public function companyTasks()
    {
        $coUsers = $this->users;
        $tasks = $coUsers->map(function ($user) {
            return $user->tasks->load('users');
        });

        return $tasks->flatten()->unique('id')->flatten();
    }

    public function canCompanyManageTask($employees)
    {

         return $this->users()->whereIn('id', $employees)->count() === count($employees);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }
}
