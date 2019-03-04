<?php

namespace App\Models;

use App\Models\Exception\RedirectException;
use App\Models\Exception\UserNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use PharIo\Manifest\Application;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
//    protected $casts = [
//        'email_verified_at' => 'datetime',
//    ];

    public function logs() {
        return $this->hasMany(UserLog::class);
    }

    public function comments()
    {
        return $this->belongsToMany(Task::class, 'task_comments');
    }

    public function tasks() {
        return $this->belongsToMany(Task::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function isBoss()
    {
        return $this->role['name'] == 'Boss';
    }

    public static function getUserAndRole($email, $password) {
        $errors = ['error' => 'Your email or password is incorrect'];

        try {
            $user = User::with('role')
                ->where("email","=", $email)
                ->firstOrFail();
        } catch(ModelNotFoundException $ex) {
            throw RedirectException::make(route('login-form'),
                $errors);
        }

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }

        throw RedirectException::make(route('login-form'), $errors);
    }

}
