
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import store from './store/index'
import VueRouter from 'vue-router';
import VeeValidate from 'vee-validate';


window.Vue = require('vue');

Vue.use(VeeValidate);
Vue.use(VueRouter);

let routes = [
    { path: '/consumers', component: require('./components/Consumers.vue') },
    { path: '/about', component: require('./components/About.vue') }
];


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
});

const app = new Vue({
    el: '#app',
    store,
    router
});
