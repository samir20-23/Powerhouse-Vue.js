<template>
  <div>
    <h1>Hello, {{ name }}!</h1>
    <button @click="changeName">Change Name</button>
  </div>
</template>
<script>
export default {
  data() {
    return {
      name: 'World'
    };
  },
  methods: {
    changeName() {
      this.name = 'Vue.js';
    }
  }
};
</script>
