<?php

namespace App\Http\Controllers\Authentication\Api;

use App\Http\Helpers\UserHelper;
use App\Http\Requests\StoreUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public $helper;
    function __construct()
    {
        $this->helper = new UserHelper();
    }
    public function index() {
        return [1,2,3];
    }

    public function store(StoreUsers $request) {
        try {
            $this->helper->store($request);
        } catch(\Exception $e) {
            return response(["message" => $e->getMessage()], 500);
        }
        return response([], 204);
    }
}
