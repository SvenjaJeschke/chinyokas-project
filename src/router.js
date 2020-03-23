import VueRouter from 'vue-router';
import Home from './views/Home';
import Notes from './views/Notes';
import Vue from 'vue';
import Music from './views/Music';
import Blog from './views/Blog';
import CreateBlogPost from './views/blog/CreateBlogPost';
import ViewBlogPost from './views/blog/ViewBlogPost';
import EditBlogPost from './views/blog/EditBlogPost';

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/notes',
            name: 'notes',
            component: Notes
        },
        {
            path: '/music',
            name: 'music',
            component: Music
        },
        {
            path: '/blog-view',
            name: 'blog-view',
            component: Blog
        },
        {
            path: '/blog-create',
            name: 'blog-create',
            component: CreateBlogPost
        },
        {
            path: '/view-blog-post/:id',
            name: 'view-blog-post',
            component: ViewBlogPost,
            props: true
        },
        {
            path: '/edit-blog-post/:id',
            name: 'edit-blog-post',
            component: EditBlogPost,
            props: true
        }
    ]
})

export default router;