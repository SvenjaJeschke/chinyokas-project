import VueRouter from 'vue-router';
import Home from './components/Home';
import Notes from './components/Notes';
import Vue from 'vue';
import MusicPlayer from './components/MusicPlayer';
import BlogView from './components/BlogView';
import CreateBlogPost from './components/CreateBlogPost';
import ViewBlogPost from './components/ViewBlogPost';
import EditBlogPost from './components/EditBlogPost';

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
            component: MusicPlayer
        },
        {
            path: '/blog-view',
            name: 'blog-view',
            component: BlogView
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