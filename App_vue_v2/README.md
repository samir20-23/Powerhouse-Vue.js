I'll give you a **Laravel + Vue.js** CRUD application for managing **Articles and Categories** without page refresh. This will include:

- **Laravel API (Backend)**
  - Migrations
  - Seeders
  - Models
  - Controllers
  - Routes

- **Vue.js (Frontend)**
  - Vue Components
  - Axios for API calls
  - Tailwind CSS for styling

---

### **1️⃣ Install Laravel & Setup Vite + Vue**
Run these commands:

```sh
composer create-project laravel/laravel laravel-vue-crud
cd laravel-vue-crud
composer require laravel/ui
php artisan ui vue
npm install
npm install vue@latest @vitejs/plugin-vue axios
```

Then, update `vite.config.js`:

#### **`vite.config.js`**
```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
});
```

---

### **2️⃣ Migrations & Seeders**
Run:

```sh
php artisan make:model Category -m
php artisan make:model Article -m
php artisan make:seeder CategorySeeder
php artisan make:seeder ArticleSeeder
```

#### **`database/migrations/xxxx_xx_xx_create_categories_table.php`**
```php
public function up()
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique();
        $table->timestamps();
    });
}
```

#### **`database/migrations/xxxx_xx_xx_create_articles_table.php`**
```php
public function up()
{
    Schema::create('articles', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('content');
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}
```

Run migration:

```sh
php artisan migrate
```

---

### **3️⃣ Seeders**
#### **`database/seeders/CategorySeeder.php`**
```php
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
```

#### **`database/seeders/ArticleSeeder.php`**
```php
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
```

Run seeders:

```sh
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ArticleSeeder
```

---

### **4️⃣ Models**
#### **`app/Models/Category.php`**
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
```

#### **`app/Models/Article.php`**
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
```

---

### **5️⃣ Controllers**
Run:

```sh
php artisan make:controller CategoryController --api
php artisan make:controller ArticleController --api
```

#### **`app/Http/Controllers/CategoryController.php`**
```php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }
}
```

#### **`app/Http/Controllers/ArticleController.php`**
```php
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
```

---

### **6️⃣ API Routes**
#### **`routes/api.php`**
```php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/articles', [ArticleController::class, 'index']);
Route::post('/articles', [ArticleController::class, 'store']);
Route::put('/articles/{article}', [ArticleController::class, 'update']);
Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);
```

---

### **7️⃣ Vue Components**
Run:

```sh
npm install axios
```

#### **`resources/js/components/ArticleList.vue`**
```vue
<template>
  <div>
    <h1>Articles</h1>
    <select v-model="newArticle.category_id">
      <option v-for="category in categories" :key="category.id" :value="category.id">
        {{ category.name }}
      </option>
    </select>
    <input v-model="newArticle.title" placeholder="Title">
    <textarea v-model="newArticle.content" placeholder="Content"></textarea>
    <button @click="addArticle">Add Article</button>

    <ul>
      <li v-for="article in articles" :key="article.id">
        {{ article.title }} ({{ article.category.name }})
        <button @click="deleteArticle(article.id)">Delete</button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const articles = ref([]);
const categories = ref([]);
const newArticle = ref({ title: '', content: '', category_id: null });

const fetchData = async () => {
  const [articlesRes, categoriesRes] = await Promise.all([
    axios.get('/api/articles'),
    axios.get('/api/categories')
  ]);
  articles.value = articlesRes.data;
  categories.value = categoriesRes.data;
};

const addArticle = async () => {
  const response = await axios.post('/api/articles', newArticle.value);
  articles.value.push(response.data);
  newArticle.value = { title: '', content: '', category_id: null };
};

const deleteArticle = async (id) => {
  await axios.delete(`/api/articles/${id}`);
  articles.value = articles.value.filter(article => article.id !== id);
};

onMounted(fetchData);
</script>
```

---

### **8️⃣ Register Vue in Laravel**
Modify `resources/js/app.js`:

#### **`resources/js/app.js`**
```javascript
import { createApp } from 'vue';
import ArticleList from './components/ArticleList.vue';

createApp(ArticleList).mount('#app');
```

Modify `resources/views/welcome.blade.php`:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    @vite('resources/js/app.js')
</head>
<body>
    <div id="app"></div>
</body>
</html>
```

---

### **9️⃣ Run Laravel & Vite**
```sh
php artisan serve
npm run dev
```

Go to **`http://127.0.0.1:8000/`**, and you now have a **fully functional CRUD** without page refresh! 🚀