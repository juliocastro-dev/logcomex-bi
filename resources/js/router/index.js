import { createRouter, createWebHistory } from "vue-router";

import notFound from '../components/NotFoundPage.vue';
import login from '../components/LoginPage.vue';
import dashboard from '../components/DashboardPage.vue';
import detailspage from '../components/DetailsPage.vue';

const routes = [
    { 
        path: '/', 
        redirect: '/dashboard',
    },
    { 
        path: '/dashboard',
        name: 'Dashboard', 
        component: dashboard,
        meta: { requiresAuth: true },
    },
    { 
        path: '/details/:id',
        name: 'Details', 
        component: detailspage, 
        props: true,
        meta: { requiresAuth: true },
    },
    { 
        path: '/login',
        name: 'Login', 
        component: login,
    },
    { 
        path: '/:pathMatch(.*)*', 
        component: notFound,
        meta: { requiresAuth: true },
    },
]

const router = createRouter({
    history: createWebHistory(),
    linkExactActiveClass: 'active',
    routes,
})

router.beforeEach((to, from, next) => {
    const accessToken = localStorage.getItem('access_token');
  if (to.matched.some(record => record.meta.requiresAuth) && !accessToken) {
    next({ name: 'login' });
  } else {
    next();
  }
});

export default router;