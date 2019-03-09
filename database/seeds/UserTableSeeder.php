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
        $companies = factory(Company::class, 4)->create()->pluck('id');

        $testingAccount = User::make([
                'first_name' => 'Olja',
                'last_name'  => 'Ivkovic',
                'email'      => 'admin@mail.com',
                'password'   => '$2y$10$ejYuVqUIXe7MyxUgPIsMQuL6j1t5XqGZlDuPrxDRwy.Xj7De.Qdki', //Secret123!
            ]);
        $testingAccount->role_id = 1;
        $testingAccount->user_status_id = 1;
        $testingAccount->company_id = 1;
        $testingAccount->save();


        factory(User::class, 24)->make()->each(function ($user, $index) use ($companies) {
           if($index < 5) {
               $user->role_id = 1;
           } else {
               $user->role_id = 2;
           }

            $user->user_status_id = rand(1,3);
            $user->company_id = $this->randEl($companies);
            $user->save();
            $user->logs()->save(factory(UserLog::class)->make());

            // logs vraca kolekciju logova za id upravo save-ovanog usera
            // sacuvacemo u bazu objekat koji vrati make() nad factory-em
            // a factory popuni polja za userlog objekat
        });
    }
}
