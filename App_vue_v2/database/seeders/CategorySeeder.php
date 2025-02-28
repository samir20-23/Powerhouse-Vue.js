<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create(['name' => 'Technology']);
        Category::create(['name' => 'Health']);
        Category::create(['name' => 'Sports']);
    }
}
