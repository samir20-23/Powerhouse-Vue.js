<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        Article::create([
            'title' => 'Laravel Vue CRUD',
            'content' => 'This is a Laravel Vue CRUD tutorial.',
            'category_id' => Category::first()->id
        ]);
    }
}


