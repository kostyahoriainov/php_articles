import Vue from 'vue'
import VueRouter from 'vue-router'
import Articles from "../views/Articles";

Vue.use(VueRouter);

const routes = [
    {
        path: '/articles/user',
        component: Articles,
        children: [
            {
                path: ':name',
                component: Articles
            }
        ]
    }

];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;
