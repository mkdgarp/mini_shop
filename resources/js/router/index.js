import { createRouter, createWebHistory } from "vue-router";
import Index from "../components/Index.vue"
import Home from "../components/Users/Home.vue"

const routes = [
    {
        path: '/',
        component: Index,
    },
    {
        path: '/home',
        component: Home,
    },
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})

export default router