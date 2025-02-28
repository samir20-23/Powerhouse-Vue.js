<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller {
    public function index() {
        return Task::all();
    }
    public function store(Request $request) {
        $task = Task::create($request->all());
        return response()->json($task);
    }
}
