<?php

namespace App\Http\Requests;

use App\Models\User;

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

        if($this->input('email')) {
            $givenEmail = User::where('email', $this->input('email'))->pluck('email');
            $user = $this->route('user');
            if(!$givenEmail->contains($user->email)) {
                $rules['email'] = ['sometimes','unique:users'];
            }
        }

        return $rules;
    }
}
