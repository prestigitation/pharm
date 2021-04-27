export default {
    install(Vue) {
        Vue.prototype.$can = function(permission) {
            for (let i = 0; i < this.$store.state.permissions.length; i++) {
                if (permission == this.$store.state.permissions[i].name) {
                    return true;
                }
            }
            return false;
        }
    }
}
