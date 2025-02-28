<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder {
    public function run() {
        Task::create(['title' => 'Task 1']);
        Task::create(['title' => 'Task 2']);
        Task::create(['title' => 'Task 3']);
    }
}
