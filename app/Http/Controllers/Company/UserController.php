<?php

namespace App\Http\Controllers\Company;

use App\Http\Helpers\UserHelper;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $helper;
    protected $model;
    protected $user;

    function __construct(UserHelper $helper)
    {
        $this->helper = $helper;
        $this->model = new User();
        $this->middleware('Before');
    }

    public function before()
    {
        $this->user = session()->get('user');
        $this->user->refresh();
        return true;
    }

    public function index()
    {
        $this->helper->index();
        $roles = Role::get()->pluck('name', 'id');
        $companyId = $this->user->company->id;
        $users = User::where('company_id', $companyId)->get();
        return view('company.users', compact('users', 'roles'));
    }

    public function update(UpdateUser $request, User $user)
    {
        $this->helper->update($user, $request);
        return redirect()->back()->with('success', 'User is successfully updated!');
    }

    public function destroy(User $user)
    {
        //
    }
}
