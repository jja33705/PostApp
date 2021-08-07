import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import PostList from './components/PostList.vue';
import PostComponent from './components/PostComponent.vue';
import AddPost from './components/AddPost.vue';
import LoginComponent from './components/LoginComponent.vue';
import RegisterComponent from './components/RegisterComponent.vue';
import EditPost from './components/EditPost.vue'


export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: PostList,
            name: 'index',
        },
        {
            path: '/post/:id',
            component: PostComponent,
            name: 'post',
        },
        {
            path: '/post/create',
            component: AddPost,
            name: 'addPost',
        },
        {
            path: '/login',
            component: LoginComponent,
            name: 'login',
        },
        {
            path: '/register',
            component: RegisterComponent,
            name: 'register',
        },
        {
            path: '/edit/:id',
            component: EditPost,
            name: 'edit',
        }
    ],
});
