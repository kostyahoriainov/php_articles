import Vue from 'vue'
import VueRouter from 'vue-router'
import Articles from "../views/Articles";
import ArticleEdit from "../views/ArticleEdit";
import ArticlesList from "../components/ArticlesList";

Vue.use(VueRouter);

const routes = [
    {
        path: '/articles/user',
        component: ArticlesList,
        children: [
            {
                path: ':name',
                component: Articles
            }
        ]
    },
    {
        path: '/articles/edit/:id',
        component: ArticleEdit,
        name: 'article-edit'
    }

];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;
