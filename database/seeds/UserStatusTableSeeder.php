<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class UserStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['Well done!', 'Try harder!' ,'Critical'];

        foreach($statuses as $status) {
            \DB::table('user_statuses')->insert([
                'name' => $status,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
