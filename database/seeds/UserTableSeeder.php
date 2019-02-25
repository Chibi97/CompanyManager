<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        // bosses
        factory(User::class, 4)->make()->each(function ($boss) {
           $boss->role_id = 1;
           $boss->save();
        });

        // employees
        factory(User::class, 20)->make()->each(function ($employee) {
            $employee->role_id = 2;
            $employee->save();
        });
    }
}