<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function create() {
        return view('auth.login');
    }

    public function store(Request $request) {
        $model = new User();

        try {
            $user = $model->getUserAndRole($request->input('email'), $request->input('password'));
            session()->put("user", $user);

        } catch(\Exception $e) {
            $e->getMessage();
        }
        $route = "login-form";

        if(session()->has("user")) {
            $authorized = session()->get('user');
            if($authorized->role['name'] == "Boss") {
                $route = "company.dashboard";
            }
            else $route = "employee.dashboard";
        }

        return redirect()->route($route)->with("error", "Your email or password is wrong.");
    }

    public function destroy() {
        if(session()->has("user")) {
            session()->forget("user");
        }
        return redirect()->route("login-form");
    }

}
