<?php
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/tasks', function () {
    return Task::all();
});

Route::post('/tasks', function (Request $request) {
    $task = Task::create(['title' => $request->title]);
    return response()->json($task);
});
