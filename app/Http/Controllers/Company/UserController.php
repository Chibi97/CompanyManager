<?php

namespace App\Http\Controllers\Company;

use App\Http\Helpers\UserHelper;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

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
        return $this->user->isPartOfCompany($this->user->company);
    }

    public function index()
    {
        $users = $this->helper->index();
        $fullNames = User::getUserNames($users);
        $roles = Role::get()->pluck('name', 'id');
        $token =  session()->get('user')->company->api_token;

        return view('company.users', compact('fullNames', 'token', 'roles'));
    }

    public function update(UpdateUser $request, User $user)
    {
        $this->helper->update($user, $request);
        return redirect()->back()->withInput(['message' => 'Success']);
    }

    public function destroy(User $user)
    {
        //
    }
}
