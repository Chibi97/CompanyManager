<?php

namespace App\Http\Requests;

class StoreUsers extends StoreUsersRequest
{
    protected function rulesOverrides()
    {
        $pass = StoreUsersRequest::SPECIAL_CHARACTERS_PASS;

        return [
            'first_name' => ['required'],
            'last_name'  => ['required'],
            'email' => ['required'],
            'company' => ['required', 'min:3', 'max:50'],
            'password' => ['required', "regex:$pass"]
        ];
    }
}
