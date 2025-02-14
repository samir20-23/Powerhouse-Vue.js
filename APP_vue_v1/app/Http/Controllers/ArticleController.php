<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Fetch all articles
    public function index()
    {
        return response()->json(Article::all());
    }

    // Store a new article
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $article = Article::create($validated);

        return response()->json($article, 201);
    }

    // Delete an article
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return response()->json(null, 204);
    }
}

