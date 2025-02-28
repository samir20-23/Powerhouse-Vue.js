<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::with('category')->get();
    }

    public function store(Request $request)
    {
        $article = Article::create($request->all());
        return response()->json($article->load('category'));
    }

    public function update(Request $request, Article $article)
    {
        $article->update($request->all());
        return response()->json($article->load('category'));
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
