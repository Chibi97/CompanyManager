<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsers extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return self::myRules() + ['company' => ['required', 'min:3', 'max:50']];
    }

    public static function myRules($flag = "required")
    {
        $specialCharactersPass = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}/';

        return [
            'first_name' => ["$flag", "alpha", "min:2", "max:50"],
            'last_name'  => ["$flag", "alpha", "min:2", "max:50"],
            'email'      => ["$flag", "unique:users", "email"],
            'password'   => ["$flag", "regex:$specialCharactersPass"],
        ];

    }

    public function messages()
    {
        return self::myMessages();
    }

    public static function myMessages()
    {
        return [
            'password.regex' => 'A password must contain min 8 characters, at least one upper case' .
                'at least one down case, and at least one special character',
        ];
    }
}
