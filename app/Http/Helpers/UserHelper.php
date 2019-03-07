<?php
/**
 * Created by PhpStorm.
 * User: oljaw
 * Date: 3/6/2019
 * Time: 6:00 PM
 */

namespace App\Http\Helpers;


use App\Models\Company;
use App\Models\Role;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserHelper
{
    public function store(Request $request) {
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

}