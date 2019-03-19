<?php

namespace App\Http\Requests;

class StoreUsers extends StoreUsersRequest
{
    protected function rulesOverrides()
    {
        $regex = StoreUsersRequest::SPECIAL_CHARACTERS_PASS;
        return [
            'email' => ['required', 'unique:users'],
            'company' => ['required', 'min:3', 'max:50'],
            'password' => ['required', "regex:$regex"]
        ];
    }
}
