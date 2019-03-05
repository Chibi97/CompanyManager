<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckUsers extends FormRequest
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
        $specialCharactersPass = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}/';

        return [
            'email'      => 'required|email',
            'password'   => ["required","regex:$specialCharactersPass"]
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'A password must contain min 8 characters, at least one upper case,
                           at least one down case, and at least one special character'
        ];
    }
}
