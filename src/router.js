import axios from 'axios';
import VueRouter from 'vue-router';
import Home from './views/Home';
import Vue from 'vue';
import Music from './views/Music';
import Blog from './views/Blog';
import CreateBlogPost from './views/blog/CreateBlogPost';
import ViewBlogPost from './views/blog/ViewBlogPost';
import EditBlogPost from './views/blog/EditBlogPost';
import Theme from './views/Theme';
import Album from './views/Album';
import CreateImagePost from './views/album/CreateImagePost';
import EditImagePost from './views/album/EditImagePost';

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/music',
            name: 'music',
            component: Music
        },
        {
            path: '/blog',
            name: 'blog',
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
        },
        {
            path: '/theme',
            name: 'theme',
            component: Theme
        },
        {
            path: '/album',
            name: 'album',
            component: Album
        },
        {
            path: '/create-image-post',
            name: 'create-image-post',
            component: CreateImagePost
        },
        {
            path: '/edit-image-post/:id',
            name: 'edit-image-post',
            component: EditImagePost,
            props: true
        }
    ]
})

router.beforeEach((to, from, next) => {
    const adminRoutes = ['blog-create', 'edit-blog-post', 'theme', 'edit-image-post'];
    if (adminRoutes.includes(to.name)) {
        const password = localStorage.getItem('password');
        axios
            .get(
                '/backend/api/auth/checkadmin.php',
                { params: { password: password } },
                { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } })
            .then(response => {
                if (!response.data.admin) {
                    console.log('Not allowed.');
                    return next({name: 'home'});
                } else {
                    next();
                }
            })
    } else {
        next();
    }
})

export default router;