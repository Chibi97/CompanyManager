<?php

namespace App\Http\Controllers\Api;

use App\Http\Helpers\CompanyManager;
use App\Http\Helpers\UserHelper;
use App\Http\Requests\StoreUsers;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public $helper;

    function __construct(UserHelper $helper)
    {
        $this->helper = $helper;
        $this->middleware("CheckApiToken")->except('store', 'login');
        $this->middleware("Before")->except('index', 'store', 'login');
        $this->middleware("Before:restrictEmployee")->only('show');
        $this->middleware("Before:bossesCan")->only('index');
        $this->middleware("Before:restrictIfHimself")->only('promote', 'demote', 'destroy');
    }

    public function restrictIfHimself(Request $request)
    {
        $userFromRoute = $request->route('user');
        $user = CompanyManager::getInstance()->retrieve('user');
        return $userFromRoute->id != $user->id;
    }

    public function bossesCan()
    {
        $user = CompanyManager::getInstance()->retrieve('user');
        if($user->isBoss()) {
            return true;
        }
    }

    public function restrictEmployee(Request $request)
    {
        $userFromToken = CompanyManager::getInstance()->retrieve('user');
        if($userFromToken->isEmployee()) {
            if($userFromToken->id == $request->route('user')->id) {
                return true;
            }
        } else if($userFromToken->isBoss()) return true;
    }

    public function before(Request $request)
    {
        $user = $request->route('user');
        if($this->restrictEmployee($request)) {
            return $user->isPartOfCompany(CompanyManager::getInstance()->retrieve('company'));
        }
    }

    public function show(User $user)
    {
        return $this->helper->show($user);
    }

    public function store(StoreUsers $request)
    {
        $user = $this->helper->store($request);
        return response(["message" => "Successfully stored!",
            "token" => $user->api_token], 201);
    }

    public function index()
    {
        return $this->helper->index();
    }

    public function update(User $user, UpdateUser $request)
    {
        $this->helper->update($user, $request);
        return response(["message" => "User successfully updated!"], 200);
    }

    public function promote(User $user)
    {
        $this->helper->promote($user);
        return response(["message" => "Successfully updated role!"], 200);
    }

    public function demote(User $user)
    {
        $this->helper->demote($user);
        return response(["message" => "Successfully updated role!"], 200);
    }

    public function destroy(User $user)
    {
        $this->helper->destroy($user);
        return response(["message" => "User successfully deleted"], 200);
    }

    public function login(Request $request) {
        $user = User::getUserAndRole($request->input('email'), $request->input('password'));
        return response($user,200);
    }
}
