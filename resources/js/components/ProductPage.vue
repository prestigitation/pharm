<template>
    <div>
        <header-component></header-component>
          <div class="product_page_content">
            <div class="d-flex flex-row justify-content-center align-items-center mt-5">
            <div class="product_page_img_block mx-3">
                <img
                :src="'/storage/img/products/' + product.id + '.jpeg'" id="product_page_img"
                width="400"
                height="400"
                >
            </div>
            <div class="product_page_info mx-4">
                <div>
                    {{ product.name }}
                </div>
                <div>
                    {{ product.category }}
                </div>
                <div>
                  <strong>
                      Цена : {{ product.price }} руб.
                  </strong>
                </div>
                <div class="mt-2">
                    <b-button variant="success" @click.prevent='buy'> Купить </b-button>
                    <b-button variant="warning"> Добавить в корзину </b-button>
                </div>
            </div>
          </div>
          <div class="product_page_bar mt-5 d-flex flex-row align-items-center justify-content-start">
            <div class="product_page_sections" @click="showComponent('product-review')"> Отзывы </div>
            <div class="product_page_sections" @click="showComponent('product-description')"> Описание </div>
            <div class="product_page_sections" @click="showComponent('product-avaliable')"> Наличие в магазинах </div>
        </div>
        <div>
            <component :is="selectedComponent"></component>
        </div>
      </div>
    </div>
</template>

<script>
import Vue from 'vue'
Vue.component('product-review', {
    template : '<span> Отзывы</span>'
})
Vue.component('product-description', {
    data() {
        return {
            description : '',
        }
    },
    created() {
        this.description = this.$parent.product.description // родителем выступает комонент ProductPage
    },
    template : '<p> {{ description }} </p>',

})
Vue.component('product-avaliable', {
    data() {
        return {
            stocks : '',
        }
    },
    async mounted() {
        let {data} = await axios.get('/api/products/' + this.$parent.product.id + '/departments')
        this.stocks = data
    },
    template : "<div> <div> Наличие в аптеках: </div> <div v-for='stock in stocks' :key='stock'> {{ stock }}</div></div>"
})
export default {
    data() {
      return {
        product : '',
        selectedComponent: null,
      }
    },
    async mounted() {
        let {data} = await axios.get('/api/products/' + this.$route.params.id)
        this.product = data;
        this.selectedComponent = 'product-description' // компонент по дефолту
    },
    methods : {
        showComponent(component) {
            this.selectedComponent = component
        },
        async buy() {
            if(this.$store.getters.getAuthUser) {
                await axios.post('/api/products/'+this.$route.params.id + '/buy',{
                    user_id : this.$store.getters.getAuthUser.userId,
                })
            } else {
                this.$bvToast.show('Для покупки товаров войдите в систему', {
                    title: 'Покупка товара',
                })
            }
        }

    }
}
</script>

<style>
    .product_page_content {
        width: 1280px;
        margin-left: auto;
        margin-right: auto;
    }
    .product_page_info {
        font-size: 25px;
        font-family: 'Montserrat',sans-serif;
    }
    .product_page_bar {
        font-size: 20px;
        height: 50px;
        text-align: center;
        background-color: rgb(178, 186, 194);
    }
    .product_page_sections {
        margin-right: 15px;
        margin-left: 15px;
    }
</style>
