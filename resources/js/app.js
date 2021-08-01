require('./bootstrap');

window.Vue = require('vue').default;
import Vue from 'vue';
import LayoutComponent from './components/layouts/LayoutComponent'

new Vue(LayoutComponent).$mount('#app');
