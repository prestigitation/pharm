<template>
  <div>
      <header-component></header-component>
      <div class="d-flex mt-5 flex-column justify-content-center align-items-center">
          <img :src="'/storage/img/news/' + article.id + '.jpeg'">
          <h3> {{ article.title }} </h3>
          <h5> {{ new Date(article.created_at).toDateString() }} </h5>
          <p>
              {{ article.content }}
          </p>
      </div>
  </div>
</template>

<script>
import HeaderComponent from './HeaderComponent.vue'
export default {
    components: { HeaderComponent },
    data(){
        return {
            article : '',
        }
    },
    async mounted() {
        await axios.get('/api/news/'+this.$route.params.id).then(result => {
            let {data} = result
            this.article = data
        })
    }
}
</script>

<style>

</style>
