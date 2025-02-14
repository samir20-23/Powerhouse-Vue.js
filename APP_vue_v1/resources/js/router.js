import { createRouter, createWebHistory } from 'vue-router';
import Articles from './components/Articles.vue';

const routes = [
    {
        path: '/articles',
        name: 'articles',
        component: Articles
    },
    // Add other routes here if needed
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
