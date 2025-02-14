<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

// use Illuminate\Routing\Route; 
Route::get('/articles', function () {
    return view('articles');  
});


// Display the articles page
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

// Other routes for CRUD operations
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
