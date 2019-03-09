<?php

namespace App\Http\Controllers\Authentication\Api;

use App\Http\Helpers\UserHelper;
use App\Http\Requests\StoreUsers;
use App\Models\User;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public $helper;
    function __construct(UserHelper $helper)
    {
        $this->helper = $helper;
    }
    public function show(User $user) {
        return $this->helper->show($user);
    }

    public function store(StoreUsers $request) {
        try {
            $this->helper->store($request);
        } catch(\Exception $e) {
            return response(["message" => $e->getMessage()], 422);
        }
        return response(["message" => "Successfully stored!"], 204);
    }
}
