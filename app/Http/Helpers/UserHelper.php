<?php

namespace App\Http\Helpers;

use App\Http\Requests\StoreUsers;
use App\Http\Requests\UpdateUser;
use App\Models\User;

class UserHelper
{
    public function store(StoreUsers $request) {
            $model = new User();
            $model->company   = $request->input('company');
            $model->firstName = $request->input('first_name');
            $model->lastName  = $request->input('last_name');
            $model->email     = $request->input('email');
            $model->password  = $request->input('password');

            return User::storeUserAndCompany($model->company, $model->firstName,
                                             $model->lastName, $model->email,
                                             $model->password);
    }

    public function show(User $user)
    {
        return $user->load('role', 'userStatus');
    }

    public function index()
    {
        if(session()->has('user')) {
            $company = session()->get('user')->company;
        } else {
            $company = CompanyManager::getInstance()->retrieve('company');
        }

        return $company->users;
    }

    public function update(User $user, UpdateUser $request)
    {
        $data = $request->all();
        return $user->updateUser($data);
    }

    public function promote(User $user)
    {
        $user->changeRole();
    }

    public function demote(User $user)
    {
        $user->changeRole('Employee');
    }

    public function destroy(User $user)
    {
        $user->deleteUser();
    }

}