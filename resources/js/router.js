import Vue from 'vue';
import Router from 'vue-router';
import Welcome from './views/Welcome.vue';
 
 
Vue.use(Router);
 
 
const routes = [
    {
        path: '/',
        name: 'welcome',
        component: Welcome
    },
    {
        path: '/categories',
        name: 'categories',
        component: () =>import('./views/Categories.vue')
    },
    {
        path: '/balai',
        name: 'balai',
        component: () =>import('./views/Balai.vue')
    },
    {
        path: '/paket',
        name: 'paket',
        component: () =>import('./views/Paket.vue')
    }
];
 
const router = new Router({
    routes: routes,
    linkActiveClass: 'active'
});
 
 
export default router;