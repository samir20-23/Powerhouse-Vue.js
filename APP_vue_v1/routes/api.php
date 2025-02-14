<?php 
use App\Http\Controllers\ArticleController;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;  

Route::get('/articles', [ArticleController::class, 'index']);
Route::post('/articles', [ArticleController::class, 'store']);
Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);
