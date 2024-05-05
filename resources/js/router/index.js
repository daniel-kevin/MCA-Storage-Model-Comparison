import { createRouter, createWebHistory } from 'vue-router';
const Index = () => import('../components/pages/index.vue')
const AboutUs = () => import('../components/pages/about-us.vue')

const routes = [
    { path: '/spa/home', name: 'index', component: Index },
    { path: '/spa/about-us', name: 'about-us', component: AboutUs },
]

const router = createRouter({
	history: createWebHistory("/"),
	routes
});

export default router;