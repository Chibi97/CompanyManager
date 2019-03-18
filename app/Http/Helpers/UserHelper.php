<?php

namespace App\Http\Helpers;

use App\Http\Requests\StoreUsers;
use App\Http\Requests\UpdateUser;
use App\Models\Exception\RedirectException;
use App\Models\User;

class UserHelper
{
    protected $model;
    public function __construct()
    {
        $this->model = new User();
    }

    public function store(StoreUsers $request) {
        $this->model->company   = $request->input('company');
        $this->model->firstName = $request->input('first_name');
        $this->model->lastName  = $request->input('last_name');
        $this->model->email     = $request->input('email');
        $this->model->password  = $request->input('password');

        return User::storeUserAndCompany($this->model->company,
                                         $this->model->firstName,
                                         $this->model->lastName,
                                         $this->model->email,
                                         $this->model->password
        );
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
        foreach ($data as $key => $val) {
            if(!$val) {
                unset($data[$key]);
            }
        }
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