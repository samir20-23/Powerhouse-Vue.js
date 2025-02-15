<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        // Get all articles
        return response()->json(Article::all());
    }

    public function store(Request $request)
    {
        // Create a new article
        $article = new Article();
        $article->title = $request->title;
        $article->body = $request->body;
        $article->rating = 0;  // Default rating is 0
        $article->save();

        return response()->json($article);
    }

    public function show($id)
    {
        // Show a single article
        return response()->json(Article::find($id));
    }
 
    public function update(Request $request, $id)
    {
        // Update an article's rating or content
        $article = Article::find($id);
        $article->title = $request->title ?? $article->title;
        $article->body = $request->body ?? $article->body;
        $article->rating = $request->rating ?? $article->rating; // Ensure rating gets updated
        $article->save();
    
        return response()->json($article); // Return updated article as JSON
    }
    
    public function destroy($id)
    {
        // Delete an article
        $article = Article::find($id);
        $article->delete();

        return response()->json(['message' => 'Article deleted successfully']);
    }
}
