<?php

namespace App\Models;

use App\Http\Helpers\CompanyManager;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        "name"
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function($model) {
            $model->generateHash();
        });
    }

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

    protected function generateHash()
    {
        $random_bytes = md5(uniqid(mt_rand(), true));
        $this->api_token = $random_bytes;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }
}
