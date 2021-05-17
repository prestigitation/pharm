<template>
  <b-form-group>
    <b-form-input @change="findProduct" v-model="productSearch" type="text" placeholder="Введите название товара"></b-form-input>
    <b-form-select v-model="productSelect" ref="productSearchResult">
        <option v-for="(product,index) in products" :key="product" @change="calculatePrice(index)">
            {{ product.name }}
        </option>
    </b-form-select>
  </b-form-group>
</template>

<script>
import UpdateDeleteFunctions from './UpdateDeleteFunctions'
export default {
    extends : UpdateDeleteFunctions,
    data() {
        return {
            productSearch : '',
            productSelect : '',
            products : '',
            productId : undefined,
        }
    },
    watch: {
        productSelect() {
            let id
            this.products.forEach(item=> {
                if(item.name == this.productSelect) {
                    id = item.id
                    this.productId = id
                    return
                }
            })
            return id
        }
    }
}
</script>
