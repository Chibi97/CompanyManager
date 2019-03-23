<?php

namespace App\Http\Requests;

class UpdateUser extends StoreUsersRequest
{

    protected function rulesOverrides()
    {
        $regex = StoreUsersRequest::SPECIAL_CHARACTERS_PASS;
        $rules = [];

        if($this->input('password')) {
            $rules['password'] = ["regex:$regex"];
        }

        if(!$this->is('api/*')) {
            $rules['role'] = ["sometimes", "regex:/^[1|2]$/"];
        }
        return $rules;
    }
}
