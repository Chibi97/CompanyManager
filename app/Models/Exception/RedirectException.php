<?php
/**
 * Created by PhpStorm.
 * User: oljaw
 * Date: 3/4/2019
 * Time: 11:34 PM
 */

namespace App\Models\Exception;


use Illuminate\Database\Eloquent\ModelNotFoundException;

class RedirectException extends ModelNotFoundException
{
    private $redirectTo;
    private $errors;

    public static function make($redirectTo, $errors = [])
    {
        $obj = new RedirectException();
        $obj->redirectTo = $redirectTo;
        $obj->errors = $errors;
        return $obj;
    }

    public function getRedirection()
    {
        return $this->redirectTo;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
