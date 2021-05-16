<template>
  <div class="order_page">
      <div class="lead"> Панель работника </div>
      <div class="order">
        <div> Оформить заказ : </div>
        <b-form-group>
            <b-form-input @change="findProduct" v-model="productSearch" type="text" placeholder="Введите название товара"></b-form-input>
            <b-form-select v-model="productSelect">
            <option v-for="(product,index) in products" :key="product" @change="calculatePrice(index)">
                {{ product.name }}
            </option>
        </b-form-select>
        </b-form-group>
        <b-form-group>
                    <quantity-selector @quantityChange='setQuantity'></quantity-selector>
                    <b-button type="submit"
                    variant="success"
                    @click="addProduct"
                    > Прикрепить к заказу </b-button>

        </b-form-group>
      </div>

      <div class="order_card">
          <b-card bg-variant="info" v-if="orderList.length>0">
              <b-card-text v-for="(product,index) in orderList" :key="product">
                  <span class="mx-2">
                      <span> {{ product.product }} </span>
                      <span class="float-right text-white">
                        <span> x{{ product.quantity }} </span>
                        <span class="mx-4"> {{ product.totalPrice }} руб.  </span>
                        <span>
                            <b-icon-x-circle
                            role="button"
                            variant="danger"
                            @click="clearOrderItem(index)"
                            ></b-icon-x-circle>
                        </span>
                      </span>
                  </span>
              </b-card-text>
          </b-card>
          <div class="d-flex flex-row">
              <div class="d-flex justify-content-start">
                  Сумма заказа : {{ orderCost }}руб.
              </div>
              <div class="d-flex col-9 justify-content-end text-right">
                Сдача : {{ cashBack }}руб.
              </div>
          </div>
          <div>
              Получено : <b-form-input type="text" v-model="recievedMoney" placeholder="Введите сумму"/>
          </div>
      </div>

      <b-button @click.prevent="addOrder" type="submit" variant="primary" class="mt-3 d-flex justify-content-center w-100">
          Добавить заказ
      </b-button>
  </div>
</template>

<script>
import QuantitySelector from '../QuantitySelector.vue'
export default {
  components: { QuantitySelector },
    data() {
        return {
            productSearch : '',
            products : '',
            productSelect : '',
            productPrice : '',
            quantity : '',
            orderList: new Array,
            productsData :'',
            orderCost : 0,
            recievedMoney : '',
        }
    },
    async mounted() {
        let {data} = await axios.get('/api/products')
        this.productsData = data
    },
    methods : {
        async findProduct() {
            let a = await axios.post('/api/products/search',{
                query : this.productSearch
            })
            this.products = a.data
        },
        setQuantity(quantity) {
            this.quantity = quantity
        },
        addProduct() {
            let orders = this.orderList
            let totalPrice = this.calculatePrice(this.productSelect)
            if(this.quantity>0) {
                orders.push({product : this.productSelect,totalPrice, quantity : this.quantity})
                this.orderList = orders
            }
        },
        calculatePrice(productName) {
            let products = this.productsData
            let selected
            products.forEach((item)=> {
                if(item.name == productName) {
                    selected = item;
                    return;
                }
            })
            this.orderCost += selected.price * this.quantity
            return selected.price * this.quantity
        },
        addOrder() {
            let formData = new FormData();
            let result = new Array();
            let orders = this.orderList
            orders.forEach((item) => {
                result.push(item)
            })
            formData.append('order',JSON.stringify(orders))
            axios.post('/api/products/departments',{order : formData.get('order'), user : this.$store.getters.getAuthUser}).then(()=>
                Vue().$bvToast('Заказ добавлен')
            ).catch(()=>Vue().$bvToast('Заказ не был добавлен. Проверьте правильность введенной формы'))
        },
        clearOrderItem(index) {
            let orderList = this.orderList
            orderList.splice(index,1)
            this.orderList = orderList
            this.orderCost = 0 // обнулить общую цену продукта
        }
    },
    computed : {
        cashBack : function() {
            return this.recievedMoney - this.orderCost
        }
    }
}
</script>

<style>
    .order_card {
        margin-left: auto;
        margin-right: auto;
    }

    .order_page {
        width: 30%;
    }
</style>
