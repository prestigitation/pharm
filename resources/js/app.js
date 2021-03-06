/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex'
import IntlMessageFormat from 'intl-messageformat';

require('./bootstrap');
const compiler = require('vue-template-compiler');
//import "tailwindcss/tailwind.css";

//import { MdButton, MdContent, MdTabs } from 'vue-material/dist/components'

//Vue.use(VueRouter);
/*import VueMaterial from 'vue-material';
import 'vue-material/dist/vue-material.min.css';
import 'vue-material/dist/theme/default.css';*/

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import PortalVue from 'portal-vue';
import Notifications from 'vue-notification';
import UserProfile from './components/UserProfile.vue';
import HeaderComponent from './components/HeaderComponent.vue';
import DashboardUsers from './components/Dashboard/DashboardUsers.vue';
import Section from './components/Dashboard/Section.vue';
import SectionAction from './components/Dashboard/SectionAction.vue';
import createPersistedState from 'vuex-persistedstate';
import { trim } from 'lodash';

import DepartmentsCreate from './components/Dashboard/DepartmentsCreate.vue'
import UsersData from './components/Dashboard/UsersData.vue';
import UsersUpdate from './components/Dashboard/UsersUpdate.vue';
import DashboardComponent from './components/Dashboard/DashboardComponent.vue';
import axios from 'axios';
import VueAxios from 'vue-axios'


window.Vue = require('vue').default;



// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('form-component', require('./components/FormComponent.vue').default);
Vue.component('header-component', require('./components/HeaderComponent.vue').default);
Vue.component('UsersData', require('./components/Dashboard/UsersData.vue').default);
Vue.component('UsersUpdate', require('./components/Dashboard/UsersUpdate.vue').default);
Vue.component('DashboardComponent', require('./components/Dashboard/DashboardComponent.vue').default);
Vue.component('Section', ('./components/Dashboard/Section.vue').default);
Vue.component('SectionAction', ('./components/Dashboard/SectionAction.vue').default);
Vue.component('DepartmentsCreate', require('./components/Dashboard/DepartmentsCreate.vue').default);


Vue.use(axios);
Vue.use(PortalVue);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(Notifications);
Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(VueAxios, axios);



export function sessionStore(status, title, message) {
    sessionStorage.setItem('status', status.toString());
    sessionStorage.setItem('title', title.toString());
    sessionStorage.setItem('message', message.toString());
}






/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.onload = function() {
    const store = new Vuex.Store({
        state: {
            auth: false,
            user_id: null,
        },
        mutations: {
            authentificate(state, userId) {
                state.auth = true;
                state.user_id = userId;
            },
            logout(state) {
                state.auth = false;
                state.user_id = undefined;
            }
        },
        getters: {
            getAuth: state => {
                return state.auth;
            },
            getAuthUser: state => {
                return state.user_id;
            },
        },
        actions: {
            sendQuery: async(context, data) => {
                    const headers = {
                        //'Content-Type': 'multipart/form-data; boundary=---------------------------974767299852498929531610575',
                        //'Content-Type': 'multipart/form-data',
                        'Content-type': 'multipart/form-data'
                    };
                    //let formData = new FormData();
                    //formData.append('data', data);
                    console.log(data);
                    //console.log(url);
                    //console.log(JSON.stringify(router.app.$route.params.action));
                    //   let url = router.app.$route.params.action.toString();
                    //let ur = new URL("https://crm" + router.app.$route.path).toString();
                    //console.log(data, url);
                    //console.log(this.$router);
                    // console.log(url);
                    Vue.axios.post(window.location.href, data, headers).then(() => console.log(response));
                }
                //url: JSON.stringify(router.app.$route.params.action),
                //url: url.url,
                //url: JSON.stringify(router.app.$route.params.action),
                //url: window.location.href,
                // url: url,
                // url: window.location.href,
        },
        plugins: [createPersistedState()],
    });

    const routes = [{
            path: '/',
            component: HeaderComponent,
            name: 'index',
        },
        {
            path: '/users/:id',
            component: UserProfile,
            name: 'user_profile',
            beforeEnter: (to, from, next) => {
                if (store.state['auth'] == true) {
                    next()
                } else {
                    next(false)
                    router.go('/')
                }

            }
        },
        {
            path: '/dashboard',
            component: DashboardComponent,
            children: [
                { path: 'users', component: DashboardUsers, name: 'users' },
                { path: ':section', component: Section, name: 'section' },
                { path: ':section/:action', component: SectionAction, name: 'section_action' },

            ],
        },

    ];
    const router = new VueRouter({
        mode: 'history',
        routes,
        hashbang: false,
    });

    new Vue({
        el: '#app',
        router,
        store,
        data() {
            return {
                user: null,
            }
        },
    })


};