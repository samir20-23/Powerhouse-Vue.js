// Articles.vue

<template>
  <div>
    <h1 class="mb-4">Articles</h1>
    
    <!-- Form to create new article -->
    <form @submit.prevent="createArticle">
      <input v-model="newArticle.title" placeholder="Title" class="form-control mb-2" required />
      <textarea v-model="newArticle.body" placeholder="Body" class="form-control mb-2" required></textarea>
      <button type="submit" class="btn btn-primary">Create Article</button>
    </form>

    <ul class="list-group mt-4">
      <li v-for="article in articles" :key="article.id" class="list-group-item">
        <h5>{{ article.title }}</h5>
        <p>{{ article.body }}</p>
        <button @click="deleteArticle(article.id)" class="btn btn-danger btn-sm">Delete</button>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      articles: [],
      newArticle: {
        title: '',
        body: ''
      }
    };
  },
  mounted() {
    this.fetchArticles();
  },
  methods: {
    // Fetch all articles
    fetchArticles() {
      axios.get('/articles')
        .then(response => {
          this.articles = response.data;
        });
    },
    
    // Create a new article
    createArticle() {
      axios.post('/articles', this.newArticle)
        .then(response => {
          this.articles.push(response.data); // Add new article to the list
          this.newArticle = { title: '', body: '' }; // Reset the form
        })
        .catch(error => {
          console.error(error);
        });
    },

    // Delete an article
    deleteArticle(id) {
      axios.delete(`/articles/${id}`)
        .then(() => {
          this.articles = this.articles.filter(article => article.id !== id); // Remove the deleted article from the list
        })
        .catch(error => {
          console.error(error);
        });
    }
  }
};
</script>
