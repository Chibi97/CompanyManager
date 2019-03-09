<?php

namespace App\Models;

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
