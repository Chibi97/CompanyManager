<?php

namespace App\Models;

use App\Http\Requests\StoreUsers;
use App\Models\DTOs\UserDTO;
use App\Models\Exception\RedirectException;
use App\Models\Exception\UserNotFoundException;
use Dotenv\Exception\ValidationException;
use function foo\func;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    private $model;

    public function setModel(UserDTO $user)
    {
        $this->model = $user;
    }

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'first_name', 'last_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_token'
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
        return $this->belongsToMany(Task::class)
            ->withPivot('is_accepted')
            ->withTimestamps();
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function userStatus() {
        return $this->belongsTo(UserStatus::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function isBoss()
    {
        return $this->role['name'] == 'Boss';
    }

    public function isEmployee()
    {
        return $this->role['name'] == 'Employee';
    }

    public function isPartOfCompany($company)
    {
        return $this->company_id == $company->id;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getUserNames()
    {
        $users = $this->company->users;
        return $users->pluck('full_name', 'id');
    }

    public static function getUserAndRole($email, $password)
    {
        $errors = ['error' => 'Your email or password is incorrect'];

        $redirectTo = "login.form";

        try {
            $user = User::with('role', 'company')
                ->where("email","=", $email)
                ->firstOrFail();
        } catch(ModelNotFoundException $ex) {
            throw RedirectException::make(route($redirectTo),
                $errors);
        }

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }

        throw RedirectException::make(route($redirectTo), $errors);
    }

    public static function storeUserAndCompany($company, $firstName, $lastName, $email, $password)
    {
        DB::beginTransaction();
        try {
            $company = Company::create(['name' => $company]);
            $role    = Role::where('name', 'Boss')->first();
            $status  = UserStatus::where('name', 'Well done!')->first();

            $user = $company->users()->make([
                'first_name' => $firstName,
                'last_name'  => $lastName,
                'email'      => $email,
                'password'   => Hash::make($password),
            ]);

            $user->role()->associate($role);
            // $user->role_id = $role->id
            $user->userStatus()->associate($status);
            $user->save();
        } catch (\Exception $e) {
            DB::rollback();
            throw new ValidationException(StoreUsers::class);
        }

        DB::commit();
        return $user->load('company');
    }

    public function updateUser($data)
    {
        DB::transaction(function() use ($data) {
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            $this->fill($data);
            return $this->save();
        });
    }

    public function changeRole($roleType = 'Boss')
    {
        $role = Role::where('name', $roleType)->first();
        $this->role()->associate($role);
        return $this->save();
    }


    public function deleteUser()
    {
        DB::transaction(function() {
            $this->delete();
            $this->tasks()->detach();
        });
    }


    public function getTasksFilteredByAcceptance($accept = 0)
    {
         $tasks =  $this->load('tasks','tasks.taskStatus',
         'tasks.taskPriority', 'tasks.users')->tasks->map(function ($task) use ($accept) {
              if($task->pivot->is_accepted == $accept) {
                  return $task;
              }
         })->filter(function ($task) {
             return $task != null;
         })->flatten();
         return $tasks;
    }

    public function getAvailableTasks()
    {
        $tasks = $this->company
            ->users
            ->each(function ($user) {
                $user->tasks;
            })
            ->load(['tasks' => function($query) {
                $query->where('count', '>', 0);
            }, 'tasks.taskStatus', 'tasks.taskPriority', 'tasks.users'])
            ->pluck('tasks')
            ->flatten()
            ->unique('id');
        return $tasks;
    }

    public function assignToTask()
    {

    }

}
