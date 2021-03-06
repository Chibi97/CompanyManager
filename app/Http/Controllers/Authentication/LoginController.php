<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Middleware\RedirectIfLogin;
use App\Http\Requests\CheckUsers;
use App\Models\User;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function __construct()
    {
        // $this->middleware(RedirectIfLogin::class)->only('whoami');
    }

    public function create() {
        return view('auth.login');
    }

    public function store(CheckUsers $request) {

        $user = User::getUserAndRole($request->input('email'), $request->input('password'));

        session()->put("user", $user);

        if($user->isBoss()) {
            return redirect()->route("company.dashboard");
        }
        else return redirect()->route("employee.dashboard");
    }

    public function whoami()
    {
        $user = session()->get("user");
        $user->refresh();
        return response(["token" => $user->api_token]);
    }

    public function destroy() {
        if(session()->has("user")) {
            session()->forget("user");
        }
        return redirect()->route("login.form");
    }

}
