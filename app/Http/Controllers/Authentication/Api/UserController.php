<?php

namespace App\Http\Controllers\Authentication\Api;

use App\Http\Helpers\CompanyManager;
use Closure;
use App\Http\Helpers\UserHelper;
use App\Http\Requests\StoreUsers;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $helper;
    function __construct(UserHelper $helper)
    {
        $this->helper = $helper;
        $this->middleware("Before")->only('show', 'update', 'destroy');
    }

    public static function before(Request $request)
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
        $this->helper->store($request);
        return response(["message" => "Successfully stored!"], 201);
    }

    public function index()
    {
        $users = $this->helper->index();
        return response($users, 200);
    }

    public function update(User $user, UpdateUser $request)
    {
        $data = $request->all();
        if($request->input('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $user->fill($data);
        $user->save();
        return response(["message" => "Successfully updated!"], 204);
    }
}
