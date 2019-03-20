<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


abstract class StoreTasksRequest extends FormRequest
{
    final public function authorize()
    {
        return true;
    }

    protected function baseRules()
    {
        return [
            'name' => ["min:3", "max:50"],
            'description' => ["min:10", "max:190"],
            'start_date' => ["bail" ,"date_format:Y-m-d H:i:s", "before_or_equal:end_date"],
            'end_date' => ["bail" ,"date_format:Y-m-d H:i:s", "after_or_equal:start_date"],
            'count' => ["numeric", "min:1", "max:20"],
            'priority' => ["alpha", "min:2", "max:30"],
            'employees' => ["array","min:1"],
            'employees.*' => ["numeric","distinct", "min:1"]
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
            "priority.alpha" => "Priority should be one of these: Low, Medium, High, Really high"
        ];
    }

    abstract protected function rulesOverrides();
}
