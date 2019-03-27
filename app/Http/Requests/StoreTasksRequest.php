<?php

namespace App\Http\Requests;

use App\Models\TaskPriority;
use Illuminate\Foundation\Http\FormRequest;


abstract class StoreTasksRequest extends FormRequest
{
    protected const NAME_REGEX = '/^.{3,50}[^;<>]$/';
    protected const DESC_REGEX = '/^.{10,190}[^;<>]$/';

    final public function authorize()
    {
        return true;
    }

    protected function baseRules()
    {
        $priorities = TaskPriority::all()->pluck('name');
        foreach($priorities as $p) {
            $priorities[] = strtolower($p);
        }
        $priorities = $priorities->implode('|');
        $regex = "/^$priorities$/";

        return [
            'name' => ["min:3", "max:50", "regex:" . self::NAME_REGEX],
            'description' => ["min:10", "max:190", "regex:" . self::DESC_REGEX],
            'start_date' => ["date_format:Y-m-d H:i:s"],
            'end_date' => ["date_format:Y-m-d H:i:s"],
            'count' => ["numeric", "min:1", "max:20"],
            'priority' => ["regex:$regex", "min:2", "max:30"],
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
        return self::baseMessages() + $this->messagesOverrides();
    }

    public function baseMessages()
    {
        $priorities = TaskPriority::all()->pluck('name')->implode(', ');

        return [
            "name.regex" => "Name should not include these special chars: ;<>",
            "description.regex" => "Description should not include these special chars: ;<>",
            "priority.regex" => "Priority should be one of these: $priorities"
        ];
    }

    abstract protected function rulesOverrides();
    abstract protected function messagesOverrides();
}
