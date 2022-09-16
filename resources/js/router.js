import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import HomePage from './pages/HomePage';
import PostsPage from './pages/PostsPage';
import AboutPage from './pages/AboutPage';
import SinglePostPage from './pages/SinglePostPage';
import Contact from './pages/ContactPage';
import ErrorNotFound from './pages/ErrorNotFound';

const router = new VueRouter({
  mode: 'history',
  routes: [
    { path: '/', name:'Home', component: HomePage },
    { path: '/Posts', name:'Post', component: PostsPage },
    { path: '/AboutPage', name:'About', component: AboutPage },
    { path: '/contact', name:'Contact', component: Contact },
    { path: '/blog/:slug', name:'Single-Post', component: SinglePostPage },
    { path: '/*', name:'404', component: ErrorNotFound }
  ]
})

export default router;