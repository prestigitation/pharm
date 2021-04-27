<template>
    <div>
        <header-component> </header-component>
        <div class="d-flex flex-column align-items-center text-center">
            <div v-if="products.length>0">
                <div class="lead mx-2 my-2"> Ваша корзина </div>
                <div class="cart_template" v-for="product in products" :key="product.name">
                    <div class="cart_product_img">
                        <img width="50" height="50" :src="'/storage/img/products/' + product.id + '.jpeg'">
                    </div>
                    <div class="cart_product_content">
                        {{ product.name }}
                    </div>
                    <b-icon-x-circle
                    variant="danger"
                    class="justify-content-end"
                    id="cart_delete"
                    role="button"
                    @click.prevent="deleteItem(product.id)"
                    ></b-icon-x-circle>
                </div>
            </div>
            <div v-else class="d-flex flex-column align-items-center mt-5 justify-content-center">
                <div> Ваша корзина пуста</div>
                <router-link to="/"> Вернуться на главную </router-link>
            </div>
        </div>

    </div>
</template>

<script>
import HeaderComponent from './HeaderComponent.vue'
export default {
    data() {
        return {
            products : '',
        }
    },
    methods : {
        deleteItem(id) {
            this.$store.dispatch('deleteCartItem',id)
        }
    },
    props:['productsId','products'],
    async mounted() {
        let productsId = this.$store.getters.getCart
        let productArray = new Array()
        productsId.forEach(async (item) => {
            let response = await axios.get('/api/products/' + item)
            productArray.push(response.data)
        })
        this.products = productArray
    }
}
</script>

<style>
    .cart_template {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        margin : 20px;
        padding: 20px;
        border-radius: 20px;
        border: 1px solid black;
    }

    .cart_product_img {
        display: flex;
        flex-basis: 25%;
        align-items: center;
        justify-content: flex-start;
    }
    .cart_product_content {
        align-items: center;
    }

    #cart_delete {
        flex-basis: 25%;
    }
</style>
