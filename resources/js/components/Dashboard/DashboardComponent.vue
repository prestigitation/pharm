<template>
<div class="container-fluid pl-0 pr-0" v-if="show">
    <nav class="navbar navbar-dark bg-dark d-block mh-10">

            <router-link to="/dashboard">
                <span>Dashboard </span>
            </router-link>

            <router-link to="/dashboard/users">
                <span>Пользователи</span>
            </router-link>

            <router-link to="/">
                <span>Вернуться на главную</span>
            </router-link>



    </nav>

    <div class="row w-100 ml-0 mr-0">
        <aside class="sidebar d-inline-block col-2 text-center">
            <ul v-for='(section_loop,section_name) in sections' :key="section_loop">
                {{ section_name }}
                 <li v-for="element in section_loop " :key="element">
                    <router-link :to="{ name: 'section_action', params: { section:section_name,action:element }}">
                        {{ element }}
                    </router-link>
                 </li>
            </ul>

        </aside>

        <div class="dashboard_content d-flex justify-content-center col-10">
            <router-view> </router-view>
        </div>
    </div>


</div>



</template>

<script>

import UsersData from './UsersData';
import UsersUpdate from './UsersUpdate';
import Section from './Section';
import SectionAction from './SectionAction';

export default {
    data:function() {
        return {
            sections: {
                users: ['create','data','update' ],
                departments: [ 'create','data','update','destroy' ],
            },
            section:  null,
            action : null,
            show : true,
        }
    },

    methods : {


    },
    watch : {
        $route : function(to,from) {
            this.show = false;
            this.$nextTick(() => { this.show = true; });
        }
    }



}
</script>

<style>

    .dashboard_content {
        background: #ec6f66; /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #ec6f66, #f3a183); /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #ec6f66, #f3a183); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ i 7+ */



    }

    .sidebar {
        height: 100vh;
        background: rgb(56, 79, 121);
        border-right: 3px solid rgb(0, 132, 255);
    }

    .sidebar>ul>li {
        list-style-type: none;
        font-size: 18px;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    .sidebar>ul {
        color: azure;
    }


</style>
