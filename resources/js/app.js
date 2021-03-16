/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex'


require('./bootstrap');

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
import ProductsCreate from './components/Dashboard/ProductsCreate.vue'
import axios from 'axios';
import VueAxios from 'vue-axios'


window.Vue = require('vue').default;


Vue.component('ProductsCreate', require('./components/Dashboard/ProductsCreate.vue').default);
Vue.component('header-component', require('./components/HeaderComponent.vue').default);
Vue.component('UsersData', require('./components/Dashboard/UsersData.vue').default);
Vue.component('UsersUpdate', require('./components/Dashboard/UsersUpdate.vue').default);
Vue.component('DashboardComponent', require('./components/Dashboard/DashboardComponent.vue').default);
Vue.component('ProductsData', require('./components/Dashboard/ProductsData.vue').default);
Vue.component('Section', ('./components/Dashboard/Section.vue').default);
Vue.component('SectionAction', ('./components/Dashboard/SectionAction.vue').default);
Vue.component('DepartmentsForm', require('./components/Dashboard/DepartmentsForm.vue').default);
Vue.component('DepartmentsData', require('./components/Dashboard/DepartmentsData.vue').default);
Vue.component('DepartmentsCreate', require('./components/Dashboard/DepartmentsCreate.vue').default);
Vue.component('DepartmentsProducts', require('./components/Dashboard/DepartmentsProducts.vue').default);
Vue.component('DealersCreate', require('./components/Dashboard/DealersCreate.vue').default);
Vue.component('DealersData', require('./components/Dashboard/DealersData.vue').default);
Vue.component('RolesData', require('./components/Dashboard/RolesData.vue').default);
Vue.component('PermissionsData', require('./components/Dashboard/PermissionsData.vue').default);



Vue.use(PortalVue);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(Notifications);
Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(VueAxios, axios);

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
    });


};