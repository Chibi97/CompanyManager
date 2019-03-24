<?php

namespace App\Http\Controllers\Api;

use App\Http\Helpers\CompanyManager;
use App\Http\Helpers\UserHelper;
use App\Http\Requests\StoreUsers;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserController extends Controller
{
    public $helper;

    function __construct(UserHelper $helper)
    {
        $this->helper = $helper;
        $this->middleware("CheckApiToken")->except('store', 'login');
        $this->middleware("Before")->except('index', 'store', 'login');
    }

    public function before(Request $request)
    {
        $user = $request->route('user');
        return $user->isPartOfCompany(CompanyManager::getInstance()->retrieve('company'));
    }

    public function show(User $user)
    {
        return $this->helper->show($user);
    }

    public function store(StoreUsers $request)
    {
        $result = $this->helper->store($request);
        return response(["message" => "Successfully stored!",
            "token" => $result->company->api_token], 201);
    }

    public function index()
    {
        return $users = $this->helper->index();
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

    public function login(Request $request){
        $user = User::getUserAndRole($request->input('email'), $request->input('password'));
        return response($user,200);
    }



}
