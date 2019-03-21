<?php

namespace App\Http\Requests;


class UpdateTask extends StoreTasksRequest
{

    protected function rulesOverrides()
    {
        $rules = [];

        if($this->input('status') || $this->input('status') == "") {
            $rules['status'] = ["regex:/^[a-zA-Z\s]+$/","min:2", "max:30"];
        }
        return $rules;
    }
}
