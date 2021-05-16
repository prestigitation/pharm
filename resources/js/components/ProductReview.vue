<template>
  <div>
      <div>
          <span class="lead m-2 d-flex justify-content-center">Отзывы({{comments.length}}) : </span>
          <div class='d-flex justify-content-center flex-column text-center w-50 ml-auto mr-auto'>
              <comment class='border border-primary p-1 m-2' v-for="comment in comments" :key="comment.id">
                  <span  class='d-flex justify-content-between' slot="comment_author">
                    <h3>
                        <span class="text-right m-1">
                            {{ comment.name }}
                        </span>
                    </h3>
                    <span class="d-inline-flex justify-content-end m-1 comment_created_at">
                        {{ comment.created_at }}
                    </span>
                  </span>
                  <div slot="comment_content">
                      {{ comment.comment }}
                  </div>
              </comment>
          </div>
      </div>
      <div v-if="$store.getters.getAuthUser.userId">
          <span class="lead d-flex justify-content-center">
              <h3> Оставьте свой отзыв:  </h3>
          </span>
          <b-form-textarea class="w-50 mr-auto ml-auto" v-model="newComment"></b-form-textarea>
          <b-button @click.prevent="sendComment" type="submit" class="w-30 m-3 mr-auto ml-auto d-flex justify-content-center" variant="success"> Отправить</b-button>
      </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            comments : '',
            newComment:''
        }
    },
    async mounted() {
        await axios.get('/api/comments/' + this.$route.params.id).then(res => {
            this.comments = res.data
        })
    },
    methods : {
        async sendComment() {
            await axios.post('/api/comments',{
                product_id: Number(this.$route.params.id),
                user_id : this.$store.getters.getAuthUser.userId,
                comment : this.newComment
            })
        }
    }
}
</script>

<style>
    .comment_created_at {
        font-size : 12px;
    }
</style>
