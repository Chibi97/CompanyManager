<?php

namespace App\Http\Requests;

class UpdateUser extends StoreRequest
{

    protected function rulesOverrides()
    {
        $regex = StoreRequest::SPECIAL_CHARACTERS_PASS;
        $rules = [];

        if($this->input('password')) {
            $rules['password'] = ["regex:$regex"];
        }

        if($this->input('role')) {
            $rules['role'] = ["regex:/^[1|2]$/"];
        }
        return $rules;
    }
}
