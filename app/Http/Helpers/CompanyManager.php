<?php

namespace App\Http\Helpers;

class CompanyManager
{
    private static $instance = null;
    private $memory = [];

    private function __construct() {}

    public static function getInstance()
    {
        if(self::$instance == null)
        {
            self::$instance = new CompanyManager();
        }

        return self::$instance;
    }

    public function remember($key, $value)
    {
        $this->memory[$key] = $value;
    }

    public function retrieve($key)
    {
        return $this->memory[$key];
    }
}