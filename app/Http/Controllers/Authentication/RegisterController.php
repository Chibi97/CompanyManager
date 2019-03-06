<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Requests\StoreUsers;
use App\Models\Company;
use App\Models\Role;
use App\Models\UserStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(StoreUsers $request)
    {
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
        $user->save();

        return redirect(route('job-offers'));
    }
}
