<?php

use App\Models\Task;
use App\Models\TaskComment;
use function foo\func;
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
            //$task->users()->save(factory(TaskComment::class)->make());
        });
    }
}
