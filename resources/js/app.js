/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
//import "tailwindcss/tailwind.css";

//import { MdButton, MdContent, MdTabs } from 'vue-material/dist/components'
import Vue from 'vue';
import VueRouter from 'vue-router';

//Vue.use(VueRouter);
/*import VueMaterial from 'vue-material';
import 'vue-material/dist/vue-material.min.css';
import 'vue-material/dist/theme/default.css';*/



import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import PortalVue from 'portal-vue';
import Notifications from 'vue-notification'

window.Vue = require('vue').default;

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('form-component', require('./components/FormComponent.vue').default);
Vue.component('header-component', require('./components/HeaderComponent.vue').default);
Vue.component('dashboard-component', require('./components/DashboardComponent.vue').default);

Vue.use(PortalVue);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(Notifications);
//Vue.use(VueRouter);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.onload = function() {
    new Vue({
        el: '#app'
    });

    new Vue({
        el: '#dashboard'
    })
}


export function sessionStore(status, title, message) {
    sessionStorage.setItem('status', status.toString());
    sessionStorage.setItem('title', title.toString());
    sessionStorage.setItem('message', message.toString());
}
