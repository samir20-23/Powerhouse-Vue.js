
import './bootstrap';
import { createApp } from 'vue';;

const app = createApp({});

import Articles from './components/Articles.vue'
app.component('articles', Articles);
app.mount('#app');
// 