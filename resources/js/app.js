/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.fire = new Vue();

/**
 * vue-select
 */

import vSelect from 'vue-select'

Vue.component('v-select', vSelect)

/**
 * vform
 */

import { Form, HasError, AlertError } from 'vform'
window.Form = Form;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

/**
 * SweetAlert2
 */
import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

/**
 * laravel-vue-pagination
 */
Vue.component('pagination', require('laravel-vue-pagination'));

/**
 * Vue router
 */

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

let routes = [
    { path: '/dashboard', name: 'dashboard', component: require('./components/pages/Dashboard').default },
    { path: '/users', component: require('./components/pages/Users').default },
    { path: '/role', component: require('./components/pages/Roles').default },
    { path: '/permission', component: require('./components/pages/Permissions').default },
]

// Create the router instance and pass the `routes` option
const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('account', require('./components/auth/Account').default);
Vue.component('account-form', require('./components/auth/AccountForm').default);
Vue.component('admin', require('./components/Admin').default);
Vue.component('dashboard', require('./components/pages/Dashboard').default);
Vue.component('users', require('./components/pages/Users').default);
Vue.component('roles', require('./components/pages/Roles').default);
Vue.component('permissions', require('./components/pages/Permissions').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
