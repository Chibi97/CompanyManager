<?php

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use App\Models\UserLog;

class UserTableSeeder extends Seeder
{
    private function randEl($arr)
    {
        $arr = $arr->toArray();
        return $arr[array_rand($arr, 1)];
    }

    public function run()
    {
        $allCompanies = factory(Company::class, 4)->create()->pluck('id');

        // bosses
        factory(User::class, 4)->make()->each(function ($boss) use ($allCompanies) {
           $boss->role_id = 1;
           $boss->user_status_id = rand(1,3);
           $boss->company_id = $this->randEl($allCompanies);
           $boss->save();
           $boss->logs()->save(factory(UserLog::class)->make());
        });

        // employees
        factory(User::class, 20)->make()->each(function ($employee) use ($allCompanies) {
            $employee->role_id = 2;
            $employee->user_status_id = rand(1,3);
            $employee->company_id = $this->randEl($allCompanies);
            $employee->save();
            $employee->logs()->save(factory(UserLog::class)->make());
            // logs vraca kolekciju logova za tog usera
            // sacuvacemo u bazu objekat koji vrati make() nad factory-em
        });
    }
}
