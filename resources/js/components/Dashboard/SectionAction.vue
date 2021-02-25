<template>
    <component :is="activeComponent"> </component>
</template>


<script>
import Section from './Section';
import userscreate from './userscreate';
export default {
    data : () => {
        return {
            //activeComponent : Section
        }
    },
    mounted: function()  {
        console.log(this.$route.params)
    },
    updated : function()  {
        console.log(this.$route.params)
    },
    computed : {
        activeComponent : function() {
            return this.$route.params.section + this.$route.params.action;
        }
    }
}
</script>
