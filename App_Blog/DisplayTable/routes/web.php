<?php

use App\Http\Controllers\displayBoardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/Welcome', function () {
    return Inertia('Welcome');
})->name('Welcome');

Route::get('/test', function () {
    return Inertia::render('Test');
})->name('test');

Route::resource('displayBoards', displayBoardController::class);

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';