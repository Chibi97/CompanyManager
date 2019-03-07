<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Helpers\UserHelper;
use App\Http\Requests\StoreUsers;
use App\Models\Company;
use App\Models\Role;
use App\Models\UserStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public $helper;
    function __construct()
    {
        $this->helper = new UserHelper();
    }

    public function create()
    {
        return view('auth.register');
    }

    public function store(StoreUsers $request)
    {
        $this->helper->store($request);

        return redirect(route('job-offers'));
    }
}
