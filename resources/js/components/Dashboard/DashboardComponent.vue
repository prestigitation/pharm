<template>
<div class="container-fluid pl-0 pr-0">
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

    <div class="row w-100">
        <aside class="sidebar d-inline-block col-2 text-center">
            <ul v-for='(section,section_name) in sections' :key='section'>
                {{ section_name }}
                 <li v-for="element in section " :key="element">
                    <router-link :to="{ name: 'section_action', params: { section:section_name,action:element }}">
                        {{ element }}
                    </router-link>
                 </li>
            </ul>

        </aside>

        <div class="content d-inline-block col-10">
            <router-view> </router-view>
        </div>
    </div>


</div>



</template>

<script>
export default {
    data : function() {
        return {
            sections: {
                users: [ 'create','data','update' ],
                departments: [ 'create','data','update','destroy' ],
            },

        }
    },

    mounted:function() {
    },
    methods : {
    }



}
</script>

<style>

    .sidebar {
        height: 93.7vh;
        background-color:burlywood;
        border-right: 3px solid rgb(0, 132, 255);
    }

    .sidebar>ul>li {
        list-style-type: none;
        font-size: 18px;
        font-family: Verdana, Geneva, Tahoma, sans-serif;

    }




</style>
