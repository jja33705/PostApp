import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import PostList from './components/PostList.vue';
import PostComponent from './components/PostComponent.vue'


export default new VueRouter({
    mode: 'history',
    routes: [{
        path: '/',
        component: PostList,
        name: 'index',
    },
    {
        path: '/post/:id',
        component: PostComponent,
        name: 'post',
    }]
});
