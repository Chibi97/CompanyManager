<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function create() {
        return view('auth.login');
    }

    public function store(Request $request) {

        $user = User::getUserAndRole($request->input('email'), $request->input('password'));
        session()->put("user", $user);

        $authorized = session()->get('user');
        if($authorized->isBoss()) {
            return redirect()->route("company.dashboard");
        }
        else return redirect()->route("employee.dashboard");

    }

    public function destroy() {
        if(session()->has("user")) {
            session()->forget("user");
        }
        return redirect()->route("login-form");
    }

}
