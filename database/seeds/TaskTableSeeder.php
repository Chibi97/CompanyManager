<?php

use App\Models\Task;
use App\Models\TaskDifficulty;
use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

class TaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Task::class, 10)->make()->each(function ($task) {
              $task->task_difficulty_id = rand(1,4);
              $task->task_status_id = rand(1,5);
              $task->save();
        });
    }
}
