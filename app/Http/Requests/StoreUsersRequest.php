<?php
/**
 * Created by PhpStorm.
 * User: oljaw
 * Date: 3/17/2019
 * Time: 12:27 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

abstract class StoreUsersRequest extends FormRequest
{
    protected const SPECIAL_CHARACTERS_PASS = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_#^\(\)\+\=\-\`\[\]\{\}\;\:\'\"\\\|\/\,\.])[A-Za-z\d@$!%*?&_#^^\(\)\+\=\-`\[\]\{\}\;\:\'\"\\\|\/\,\.]{8,}$/';
    protected const NAME = '/^[A-Z][a-z]{2,48}(\s([A-Z][a-z]{1,48}))*$/';

    final public function authorize()
    {
        return true;
    }

    protected function baseRules()
    {
        return [
            'first_name' => ['alpha', 'min:2', 'max:50', 'regex:' . self::NAME],
            'last_name'  => ['alpha', 'min:2', 'max:50', 'regex:' . self::NAME],
            'email'      => ['email'],
            'password'   => [],
        ];
    }

    final public function rules()
    {
        $overrides = $this->rulesOverrides();
        $base = $this->baseRules();
        foreach ($overrides as $field => $rules) {
            foreach($rules as $rule) {
                $base[$field][] = $rule;
            }
        }
        return $base;
    }

    final public function messages()
    {
        return [
            'password.regex' => 'A password must contain min 8 characters, at least one upper case' .
                'at least one down case, and at least one special character',
            'first_name' => 'First name must begin with capital letters',
            'last_name' => 'Last name must begin with capital letters'

        ];
    }

    abstract protected function rulesOverrides();
}