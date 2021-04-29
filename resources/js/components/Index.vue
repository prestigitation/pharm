<template>
    <div>
        <header-component></header-component>
        <div class="text-center m-3 lead"> Наши покупатели выбирают: </div>
        <div class="d-flex justify-content-center">
            <product v-for="(product,index) in products" :key="index">
                <div slot="img">
                    <img :src="'/storage/img/products/' + product.id + '.jpeg'" class="product_img d-flex">
                </div>
               <div slot="data">
                   <router-link :to="'/products/'+(index+1)">
                        <strong> {{ product.name }} </strong>
                   </router-link>
                   <div> {{ product.category }}</div>
               </div>
               <div slot="price" class="text-center">
                   {{ product.price }}руб.
                    <b-button variant="warning" size="sm" @click="$store.dispatch('addToCart',index+1)">
                        🛒
                    </b-button>
               </div>
            </product>
        </div>

        <div class="d-flex justify-content-center align-items-center">
           <div class='text-center m-3 lead'> По категориям : </div>
        </div>
        <div class="categories">
            <category v-for="category in categories" :key="category" class="mx-1 d-flex flex-row justify-content-center">
                    <div slot="text">
                        <router-link :to="'/filter?category='+category.name">
                            {{ category.name }}
                        </router-link>
                    </div>
            </category>
        </div>
        <div class="text-center m-3 lead"> Новости </div>
        <div class="news">
            <news class="mr-auto ml-auto" v-for="article in news" :key='article.id' :link="'/news/'+article.id">
                <div slot="img">
                    <img class="news_img" :src="'/storage/img/news/'+ article.id + '.jpeg'">
                </div>
                <h5 slot='title' class="text-center">{{ article.title }}</h5>
                <span slot='data' class="d-flex justify-content-center">{{ new Date(article.created_at).toDateString() }}</span>
                <div slot='content' class="text-center">{{ article.content }}</div>
            </news>
        </div>
    </div>
</template>

<script>
import Category from './Category.vue'
import HeaderComponent from './HeaderComponent.vue'
import Product from './Product.vue'
import News from './News.vue'
export default {
  components: { Category },
    data() {
        return {
            products : '',
            categories: '',
            news:'',
        }
    },
    async mounted() {
        let {data} = await axios.get('/api/products')
        this.products = data.slice(0,5);
        let categories = await axios.get('/api/categories')
        this.categories = categories.data.slice(0,9)
        let news = await axios.get('/api/news')
        let newsData = news.data
        this.news = newsData.slice(newsData.length-7,newsData.length)


    }
}
</script>

<style>
    .categories {
        width: 100%;
        display: inline-flex;
        justify-content: center;
        justify-items: center;
        align-items: center;
        align-content: center;
        text-align: center;
    }
    .product_img {
        margin-top: 25px;
        margin-bottom: 10px;
        margin-left: auto;
        margin-right: auto;
        width: 160px;
        height: 160px;
    }
    .news {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .news>div {
        flex-grow: 1;
    }
    .news_img {
        margin: 10px;
        width:100px;
        height:100px;
        display: flex;
        margin-left: auto;
        margin-right: auto;
    }

    @media screen and (max-width:641px) {
        .categories {
            flex-direction: column;
        }
    }
</style>
