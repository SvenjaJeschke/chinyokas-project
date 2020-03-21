import VueRouter from 'vue-router';
import Home from './components/Home';
import Notes from './components/Notes';
import Vue from 'vue';
import MusicPlayer from './components/MusicPlayer';
import BlogView from './components/BlogView';

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
        }
    ]
})

export default router;