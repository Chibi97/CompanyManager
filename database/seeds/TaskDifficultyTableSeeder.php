<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TaskDifficultyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $difficulties = ['Really hard','Hard','Medium', 'Easy peasy'];

        foreach($difficulties as $diff) {
            \DB::table('task_difficulties')->insert([
                'name' => $diff,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
