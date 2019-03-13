<?php
/**
 * Created by PhpStorm.
 * User: oljaw
 * Date: 3/6/2019
 * Time: 6:00 PM
 */

namespace App\Http\Helpers;


use App\Http\Requests\StoreUsers;
use App\Http\Requests\UpdateUser;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserHelper
{
    public function store(StoreUsers $request) {
        DB::beginTransaction();
        try {
            $company = Company::create(['name' => $request->input('company')]);
            $role    = Role::where('name', 'Boss')->first();
            $status  = UserStatus::where('name', 'Well done!')->first();

            $user = $company->users()->make([
                'first_name' => $request->input('first_name'),
                'last_name'  => $request->input('last_name'),
                'email'      => $request->input('email'),
                'password'   => Hash::make($request->input('password')),
            ]);

            $user->role()->associate($role);
            // $user->role_id = $role->id
            $user->userStatus()->associate($status);
            $user->save();

        } catch(\Exception $e) {
            DB::rollBack();
            throw new ValidationException(StoreUsers::class);
        }

        DB::commit();
        return $user->load('company');
    }

    public function show(User $user)
    {
        return $user;
    }

    public function index()
    {
        $company = CompanyManager::getInstance()->retrieve("company");
        return $company->users;
    }

    public function update(User $user, UpdateUser $request)
    {
        $data = $request->all();
        if($request->input('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }
        $user->fill($data);
        return $user->save();
    }

    public function promote(User $user, $roleType = 'Boss')
    {
        try {
            $role = Role::where('name', $roleType)->pluck('id')[0];
            $user->role_id = $role;
            $user->save();
        } catch(\Exception $e) {
        }

        return $user;
    }

    public function demote(User $user)
    {
        $this->promote($user, 'Employee');
    }

    public function updateCompany(User $user, UpdateUser $request)
    {

    }

}