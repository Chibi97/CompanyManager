<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        "name"
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }

//Product::select('id', 'name', 'code')
//->with('ProductPrice', 'ProductPictures')
//->where('categoryid', 1)
//->get();
}
