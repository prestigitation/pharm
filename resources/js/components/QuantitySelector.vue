<template>
    <div class="text-center mt-3 mb-3">
        <b-form-input class="text-center" type="text" v-model="quantity" placeholder="Введите количество товара"/>
        <b-icon-plus-circle
        variant="success"
        role="button"
        scale="1.5"
        class="mx-2 mt-3"
        @click="increment()"
        ></b-icon-plus-circle>

        <b-icon-file-minus
        variant="danger"
        role="button"
        scale="1.5"
        class="mx-2 mt-3"
        @click="decrement()"
        ></b-icon-file-minus>
    </div>
</template>

<script>
export default {
    data() {
        return {
            quantity : '',
        }
    },
    methods : {
        increment() {
            if(this.quantity=='') {
                this.quantity = 1
            } else this.quantity++
        },
        decrement() {
            if(this.quantity==1) {
                this.quantity = ''
            } else if(this.quantity>1) this.quantity--
        },
    },
    watch : {
        quantity() {
            this.$emit('quantityChange',this.quantity)
        }
    }
}
</script>

<style>
    .quantity_selector {
        border : 1px solid black;
    }
</style>
