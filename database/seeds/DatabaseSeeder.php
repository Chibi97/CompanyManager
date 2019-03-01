<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TruncateDBSeeder::class,
            RoleTableSeeder::class,
            UserStatusTableSeeder::class,
            UserTableSeeder::class,
            TaskPriorityTableSeeder::class,
            TaskStatusTableSeeder::class,
            TaskTableSeeder::class,
            JobOfferTableSeeder::class,
            ConditionTableSeeder::class
        ]);
    }
}
