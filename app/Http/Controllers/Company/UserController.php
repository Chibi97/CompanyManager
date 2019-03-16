<?php

namespace App\Http\Controllers\Company;

use App\Http\Helpers\UserHelper;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public $helper;

    function __construct(UserHelper $helper)
    {
        $this->helper = $helper;
    }

    public function index()
    {
        $users = $this->helper->index();
        $fullNames = User::getUserNames($users);
        $roles = Role::get()->pluck('name', 'id');
        $token =  session()->get('user')->company->api_token;

        return view('company.users', compact('fullNames', 'token', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}
