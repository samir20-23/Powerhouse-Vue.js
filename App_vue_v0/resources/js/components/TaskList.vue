<template>
    <div>
      <h1>Tasks</h1>
      <ul>
        <li v-for="task in tasks" :key="task.id">{{ task.title }}</li>
      </ul>
      <input v-model="newTask" placeholder="Enter task">
      <button @click="addTask">Add Task</button>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  const tasks = ref([]);
  const newTask = ref("");
  
  const fetchTasks = async () => {
    const response = await axios.get("/api/tasks");
    tasks.value = response.data;
  };
  
  const addTask = async () => {
    if (newTask.value.trim() === "") return;
    const response = await axios.post("/api/tasks", { title: newTask.value });
    tasks.value.push(response.data); // Update UI without refresh
    newTask.value = ""; // Clear input
  };
  
  onMounted(fetchTasks);
  </script>
  