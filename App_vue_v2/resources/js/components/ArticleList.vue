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
  