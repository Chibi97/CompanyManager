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
        $user = $model->getUserAndRole($request->input('email'), Hash::make($request->input('password')));
        //dd($user);
        session()->put("user", $user);

        //dd(session()->get('user'));

        if(session()->has("user")) {
            $authorized = session()->get('user');
            if($authorized->role['name'] == "Boss") {
                return redirect()->route("company.dashboard");
            }
            return redirect()->route("employee.dashboard");
        }
        return redirect()->route("job-offers");
    }

    public function destroy() {
        if(session()->has("user")) {
            session()->forget("user");
        }

        return redirect()->route("login-form");
    }

}
