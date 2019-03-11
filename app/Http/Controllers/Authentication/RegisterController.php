<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Helpers\UserHelper;
use App\Http\Middleware\RedirectIfLogin;
use App\Http\Requests\StoreUsers;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public $helper;

    function __construct(UserHelper $helper)
    {
        $this->helper = $helper;
    }

    public function create()
    {
        return view('auth.register');
    }

    public function store(StoreUsers $request)
    {
        $user = $this->helper->store($request);
        session()->put("user", $user);

        return redirect(route('job-offers'));
    }
}
