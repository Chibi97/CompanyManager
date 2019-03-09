<?php
/**
 * Created by PhpStorm.
 * User: oljaw
 * Date: 3/6/2019
 * Time: 6:00 PM
 */

namespace App\Http\Helpers;


use App\Http\Requests\StoreUsers;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers;

class UserHelper
{
    public function store(StoreUsers $request) {
        $company = Company::create(['name' => $request->input('company')]);
        $role    = Role::where('name', 'Boss')->first();
        $status  = UserStatus::where('name', 'Well done!')->first();

        $user = $company->users()->make([
            'first_name' => $request->input('first-name'),
            'last_name'  => $request->input('last-name'),
            'email'      => $request->input('email'),
            'password'   => Hash::make($request->input('password')),
        ]);

        $user->role()->associate($role);
        // $user->role_id = $role->id
        $user->userStatus()->associate($status);
        return $user->save();

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

}