<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            $limit = random_int(2, 4);

            for ($i = 0; $i < $limit; $i++) {
                $task = factory(Task::class)->make();
                $task->user()->associate($user);
                $task->save();
            }
        }
    }
}
