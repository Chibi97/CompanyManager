<?php

use App\Models\Task;
use App\Models\TaskComment;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskCommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $users = User::all()->pluck('id')->toArray();
        $tasks = Task::all()->pluck('id')->toArray();

        factory(TaskComment::class, 10)->make()->each(function($comment) use($faker, $users, $tasks) {
            $comment->user_id = $faker->randomElement($users);
            $comment->task_id = $faker->randomElement($tasks);
        });
    }
}
