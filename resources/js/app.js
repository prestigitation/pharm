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
import HeaderComponent from './components/HeaderComponent.vue';
import DashboardUsers from './components/Dashboard/DashboardUsers.vue';
import Section from './components/Dashboard/Section.vue';
import SectionAction from './components/Dashboard/SectionAction.vue';
import createPersistedState from 'vuex-persistedstate';
import { trim } from 'lodash';

import UsersData from './components/Dashboard/UsersData.vue';
import UsersUpdate from './components/Dashboard/UsersUpdate.vue';
import DashboardComponent from './components/Dashboard/DashboardComponent.vue';
import WorkersData from './components/Dashboard/WorkersData.vue'
import axios from 'axios';
import VueAxios from 'vue-axios'
import rolePlugin from './plugins/rolePlugin'
import Index from './components/Index.vue'
import Product from './components/Product.vue'
import Category from './components/Category.vue'
import ProductPage from './components/ProductPage.vue'
import Cart from './components/Cart.vue'
import Filter from './components/Filter.vue'
import NewsPage from './components/NewsPage.vue'
import UserMainInfo from './components/UserMainInfo.vue'


window.Vue = require('vue').default;
const d3 = require('d3')

Vue.component('ProductsForm', require('./components/Dashboard/ProductsForm.vue').default);
Vue.component('header-component', require('./components/HeaderComponent.vue').default);
Vue.component('UsersData', require('./components/Dashboard/UsersData.vue').default);
Vue.component('UsersUpdate', require('./components/Dashboard/UsersUpdate.vue').default);
Vue.component('DashboardComponent', require('./components/Dashboard/DashboardComponent.vue').default);
Vue.component('ProductsData', require('./components/Dashboard/ProductsData.vue').default);
Vue.component('Section', ('./components/Dashboard/Section.vue').default);
Vue.component('SectionAction', ('./components/Dashboard/SectionAction.vue').default);
Vue.component('DepartmentsForm', require('./components/Dashboard/DepartmentsForm.vue').default);
Vue.component('DepartmentsData', require('./components/Dashboard/DepartmentsData.vue').default);
Vue.component('DepartmentsProducts', require('./components/Dashboard/DepartmentsProducts.vue').default);
Vue.component('DealersData', require('./components/Dashboard/DealersData.vue').default);
Vue.component('RolesData', require('./components/Dashboard/RolesData.vue').default);
Vue.component('Index', require('./components/Index.vue').default);
Vue.component('Category', require('./components/Category.vue').default);
Vue.component('Product', require('./components/Product.vue').default);
Vue.component('ProductPage', require('./components/ProductPage.vue').default);
Vue.component('Cart', require('./components/Cart.vue').default);
Vue.component('WorkersData', require('./components/Dashboard/WorkersData.vue').default);
Vue.component('WorkersPanel', require('./components/Dashboard/WorkersPanel.vue').default);
Vue.component('Filter', require('./components/Filter.vue').default);
Vue.component('News', require('./components/News.vue').default);
Vue.component('NewsData', require('./components/Dashboard/NewsData.vue').default);
Vue.component('NewsForm', require('./components/Dashboard/NewsForm.vue').default);
Vue.component('NewsPage', require('./components/NewsPage.vue').default);
Vue.component('UserMainInfo', require('./components/UserMainInfo.vue').default);
Vue.component('QuantitySelector', require('./components/QuantitySelector.vue').default);
Vue.component('ProductReview', require('./components/ProductReview.vue').default);
Vue.component('Comment', require('./components/Comment.vue').default);

Vue.use(PortalVue);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(Notifications);
Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(VueAxios, axios);
Vue.use(rolePlugin); // самописный плагин. см. папку plugins


window.onload = function() {
    const store = new Vuex.Store({
        state: {
            auth: false,
            user_id: undefined,
            permissions: undefined,
            cart: undefined
        },
        mutations: {
            authentificate(state, userId) {
                state.auth = true;
                state.user_id = userId;
            },
            logout(state) {
                state.auth = false;
                state.user_id = undefined;
                state.permissions = undefined;
            },
            permissionsAll(state, permissions) {
                state.permissions = permissions;
            },
            newCartItem(state, newCart) {
                state.cart = newCart
            },
            removeCartItem(state, newCart) {
                state.cart = newCart
            },
            deleteCart(state) {
                state.cart = undefined
            },
        },
        actions: {
            async permissionsGet(state) {
                let { data } = await axios.get('/api/users/' + this.state.user_id.userId + '/permissions');
                store.commit('permissionsAll', data);
            },
            async addToCart(state, product) { // добавление нового товара в корзину, при этом без повторений
                let successMessage = () => new Vue().$bvToast.toast('Товар успешно добавлен в корзину!', {
                    variant: 'success',
                    title: 'Корзина'
                })
                let failMessage = () => new Vue().$bvToast.toast('Товар не был добавлен в корзину. Возможно, он уже был добавлен', {
                    variant: 'danger',
                    title: 'Корзина'
                })
                let cart = store.getters.getCart
                console.log(typeof cart)
                let newArray = new Array();
                if (typeof cart == 'undefined') {
                    newArray.push({ id: product.id, quantity: product.quantity })
                    store.commit('newCartItem', newArray)
                    successMessage()
                } else if (typeof cart == 'number') {
                    if (cart != product.id) {
                        newArray.push(cart, { id: product.id, quantity: product.quantity })
                        store.commit('newCartItem', newArray)
                        successMessage()
                    }
                } else if (typeof cart == 'object') {
                    let result = true;
                    cart.forEach((item) => {
                        if (item.id == product.id) {
                            result = false
                            failMessage()
                            return
                        }
                    })
                    if (result == true) {
                        newArray.push(...cart, { id: product.id, quantity: product.quantity })
                        store.commit('newCartItem', newArray)
                        successMessage()
                    }
                }
            },
            deleteCartItem(state, id) {
                let cart = store.getters.getCart
                cart.splice(id, 1)
                store.commit('removeCartItem', cart)
            }
        },
        getters: {
            getAuth: state => state.auth,
            getAuthUser: state => state.user_id,
            getUserPermissions: state => state.permissions,
            getCart: state => state.cart
        },
        plugins: [createPersistedState()],

    });

    const routes = [{
            path: '/',
            component: Index,
            name: 'index',
        },
        {
            path: '/news/:id',
            component: NewsPage,
            name: 'news',
        },
        {
            path: '/products/:id',
            component: ProductPage,
            name: 'product',
        },
        {
            path: '/filter',
            component: Filter,
            name: 'filter'
        },
        {
            path: '/cart',
            component: Cart,
            name: 'cart'
        },
        {
            path: '/users/:id',
            component: UserMainInfo,
            name: 'user_profile',
            beforeEnter: (to, from, next) => {
                let { userId } = store.getters.getAuthUser
                if (store.state['auth'] == true && userId == to.params.id) {
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

    router.beforeEach((to, from, next) => {
        if (store.getters.getUserPermissions != undefined) {
            next()
        } else {
            store.dispatch('permissionsGet');
            next()
        }
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
