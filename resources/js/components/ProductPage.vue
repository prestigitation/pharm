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
                    <quantity-selector @quantityChange='setQuantity'></quantity-selector>
                    <b-button variant="success" @click.prevent='buy'> Купить </b-button>
                    <b-button variant="warning" @click.prevent='addToCart(product.id,quantity)'> Добавить в корзину </b-button>
                </div>
            </div>
          </div>
          <div class="product_page_bar mt-5 d-flex flex-row align-items-center justify-content-start">
            <div role="button" class="product_page_sections" @click="showComponent('product-review')"> Отзывы </div>
            <div role="button" class="product_page_sections" @click="showComponent('product-description')"> Описание </div>
            <div role="button" class="product_page_sections" @click="showComponent('product-avaliable')"> Наличие в магазинах </div>
        </div>
        <div>
            <component :is="selectedComponent"></component>
        </div>
      </div>
    </div>
</template>

<script>
import Vue from 'vue'
import QuantitySelector from './QuantitySelector.vue'
import UpdateDeleteFunctions from './Dashboard/UpdateDeleteFunctions.vue'
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
        console.log(data)
    },
    template : `
    <div class="d-flex align-items-center flex-column ml-auto mr-auto mt-2">
        <div> Наличие в аптеках: </div>
        <div class='p-2 m-2' v-for='stock in stocks' :key='stock'>
            <img :src="'/storage/img/departments/' + stock.id +'.jpeg'" width='50' height='50'>
            <span>{{ stock.city }} {{ stock.address }}</span>
        </div>
    </div>`
})
export default {
  components: { QuantitySelector },
  extends : UpdateDeleteFunctions,
    data() {
      return {
        product : '',
        selectedComponent: null,
        quantity: '',
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
                    'quantity' : this.quantity
                })
            } else {
                this.$bvToast.show('Для покупки товаров войдите в систему', {
                    title: 'Покупка товара',
                })
            }
        },
        setQuantity(quantity) {
            this.quantity = quantity
        },
        addToCart(id,quantity) {
            if(quantity == '')
            quantity = 1
            addItemToCart(product.id,quantity)
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
