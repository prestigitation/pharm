<template>
    <div class="justify-content-center filter_container">
        <header-component></header-component>
        <div class="filter-content d-flex justify-content-center">
            <aside class="filter-aside col-2 d-flex flex-column align-items-center justify-content-center mt-3 mb-4">
                <span class='filter-headers d-flex'> По категориям : </span>
                <div class="categories_block" ref="categories_block">
                    <b-form-checkbox-group v-model="selectedCategories" v-for="category in categories" :key="category.id">
                        <b-form-checkbox :value="category.name">
                            {{ category.name }}
                        </b-form-checkbox>
                    </b-form-checkbox-group>
                </div>
                <div class="d-flex justify-content-center">
                    <div role="button" v-if="!wasAllCategoriesShown" @click="showMoreCategories">
                        Показать больше <b-icon-arrow-down-circle/>
                    </div>
                    <div role="button" v-else @click="hideCategories">
                        Меньше категорий <b-icon-arrow-up-circle/>
                    </div>
                </div>
                <span class="filter-headers">По цене : </span>
                <div class="filter-price text-center">
                   от {{ Math.min(...allProductsPrices) }} до {{ Math.max(...allProductsPrices) }}
                   <b-input placeholder="Введите свою цену" type="text" v-model="price"></b-input>
                </div>
                <span class="filter-headers">По названию : </span>
                <div class="filter-price text-center">
                   <b-input placeholder="Введите название" type="text" v-model="search"></b-input>
                </div>
                <b-button @click="filter" type="submit" class="w-75 m-3 mr-auto ml-auto" variant="success"> Применить фильтры </b-button>
            </aside>
            <main class="filter-main col-10 d-flex flex-column justify-content-center align-items-center">
                <div class="d-flex justify-content-center align-items-center">
                    <product v-for="product in products" :key="product.id">
                        <div slot="img">
                            <img :src="'/storage/img/products/' + product.id + '.jpeg'" class="product_img d-flex">
                        </div>
                        <div slot="data">
                            <router-link :to="'/products/'+ product.id">
                                    <strong> {{ product.name }} </strong>
                            </router-link>
                            <div> {{ product.category }}</div>
                        </div>
                        <div slot="price" class="text-center">
                            {{ product.price }}руб.
                                <b-button variant="warning" size="sm" @click="$store.dispatch('addToCart',product.id)">
                                    🛒
                                </b-button>
                        </div>
                    </product>
                </div>
            <div class="d-flex justify-content-center">
                <b-pagination
                v-model="currentPage"
                :total-rows="rows"
                :per-page="perPage"
                aria-controls="my-table"
                @page-click='selectPage'
                ></b-pagination>
            </div>
        </main>
        </div>
    </div>
</template>

<script>
import HeaderComponent from './HeaderComponent.vue'
export default {
    data() {
        return {
            products: '',
            currentPage : 1,
            perPage : 3,
            allProducts : '',
            categories : '',
            selectedCategories : [],
            wasAllCategoriesShown : false,
            price : '',
            search : '',
            wasFiltered : false,
        }
    },
    props : ['rows','allProductsPrices'],
    async mounted() {
        let category = this.$route.query.category // если был задан запрос с index page с параметром категории
        if(category) {
            let formData = new FormData()
            formData.append('filter',JSON.stringify({
                categories : [category],
            }))
            await axios.post('/api/filter',formData,{
                'Content-Type' : 'application/json'
            }).then(res=>{
                this.wasFiltered = true
                let prods = res.data
                this.currentPage = 1
                this.allProducts = prods[0]
                this.products = this.allProducts.slice(this.currentPage-1, this.perPage)
            })
        } else {
            let {data} = await axios.get('/api/products')
            this.allProducts = data
            this.products = this.allProducts.slice(this.currentPage-1, this.perPage)
            let categories = await axios.get('/api/categories')
            this.categories = categories.data
        }
    },
    computed : {
        rows() {
            console.log(this.allProducts.length)
            return this.allProducts.length

        },
        allProductsPrices() {
            let result = new Array()
            for(let product of this.allProducts) {
                result.push(product.price)
            }
            return result
        }
    },
    methods : {
        showMoreCategories() {
            this.wasAllCategoriesShown = true;
            this.$refs.categories_block.style.height='auto'
        },
        hideCategories() {
            this.wasAllCategoriesShown = false;
            this.$refs.categories_block.style.height='200px'
        },
        selectPage(event,page) {
            let newPage
            if(page==1) {
                newPage = page
            } else {
                newPage = this.currentPage+page
            }
            this.products = this.allProducts.slice(newPage,newPage+this.perPage)
            this.currentPage = page
        },
        async filter() {
            let formData = new FormData()
            formData.append('filter',JSON.stringify({
                categories : this.selectedCategories,
                search : this.search,
                price : this.price
            }))
            await axios.post('/api/filter',formData,{
                'Content-Type' : 'application/json'
            }).then(res=>{
                this.wasFiltered = true
                let prods = res.data
                this.currentPage = 1
                this.allProducts = prods[0]
                this.products = this.allProducts.slice(this.currentPage-1, this.perPage)
            })
        }
    }
}
</script>

<style>
    .filter_container,
    .filter-content {
        min-height: inherit;
    }
    .categories_block {
        height: 200px;
        overflow: hidden;
    }
    .filter-headers {
        margin-top: 15px;
        margin-bottom: 15px;
        font-family: monospace;
        font-size: 18px;
        text-align: center;
        justify-content: center;
    }
</style>
