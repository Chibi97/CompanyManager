<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name', 'description', 'start_date', 'end_date', 'count'
    ];

    public function difficulty() {
        return $this->belongsTo(TaskDifficulty::class);
    }

    public function status() {
        return $this->belongsTo(TaskStatus::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->using(TaskComment::class);
    }
}
