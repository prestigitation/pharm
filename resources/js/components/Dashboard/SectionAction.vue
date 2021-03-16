<template>
<keep-alive>
    <component :is="activeComponent"> </component>
</keep-alive>

</template>


<script>


import DashboardComponent from './DashboardComponent';
import Section from './Section';
import UsersData from './UsersData';
import UsersUpdate from './UsersUpdate';
import ProductsCreate from './ProductsCreate';
import DealersCreate from './DealersCreate';
import DepartmentsProducts from './DepartmentsProducts';
import ProductsData from './ProductsData';
import DepartmentsForm from './DepartmentsForm';
import RolesData from './RolesData';
import PermissionsData from './PermissionsData';


export default {
    data()  {
        return {
            section:  this.$route.params.section,
            action :  this.$route.params.action,
        }

    },
    computed : {

        activeComponent : function() {
          // return str.substring(0)[0].toLocaleUpperCase() + str.substring(0)[1];
            let sectionUppercase = this.section.substring(0)[0].toLocaleUpperCase();
            let sect = this.section.substring(1);
            let actionUppercase = this.action.substring(0)[0].toLocaleUpperCase();
            let act = this.action.substring(1);
            return sectionUppercase + sect + actionUppercase + act;
        },
    },
    watch : {

    }


}
</script>
