import {createRouter, createWebHistory} from 'vue-router';
import Base from './components/Base.vue';
import ArticleList from './components/ArticleList.vue';
import ArticleDetail from './components/ArticleDetail.vue';
import CreateArticle from './components/CreateArticle.vue';
import UpdateArticle from './components/UpdateArticle.vue';
import DeleteArticle from './components/DeleteArticle.vue';

const routes = [
    {'path': '/', component: Base, redirect: '/articles'},
    {'path': '/articles', component: ArticleList},
    {'path': '/article/:id', component: ArticleDetail},
    {'path': '/create', component: CreateArticle},
    {'path': '/update/:id', component: UpdateArticle},
    {'path': '/delete/:id', component: DeleteArticle},
    {'path': '/:catchAll(.*)', redirect: '/'}
    
]

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;