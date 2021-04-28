<template>
  <div>
      <span> Вы можете добавить новость : </span>
      <b-form @submit.prevent="addNews">
          <b-form-input
          class="my-2"
          type="text"
          v-model="title"
          placeholder="Заголовок новости"
          ></b-form-input>
          <b-form-textarea class="my-2" v-model="content"></b-form-textarea>
          <b-form-file v-model="file" placeholder="Прикрепите скриншот"></b-form-file>
          <b-button type="submit" class="d-flex w-50 justify-content-center mr-auto ml-auto mt-2" variant="success"> Отправить </b-button>
      </b-form>
  </div>
</template>

<script>
export default {
    data() {
        return {
            file: File,
            title: '',
            content: '',
        }
    },
    methods: {
        async addNews() {
            let formData = new FormData()
            formData.append('file',this.file)
            formData.append('title',this.title)
            formData.append('content',this.content)
            await axios.post('/api/news',formData, {
                "Content-Type" : 'application/x-www-form-urlencoded'
            }).then(result => this.$bvToast.show('Новость успешно добавлена',{
                title: 'Добавление новости',
                variant: "success"
            })).catch(result => this.$bvToast.show('Новость не была отправлена. Проверьте параметры запроса',{
                title: 'Добавление новости',
                variant: "danger"
            }))
        }
    }
}
</script>

<style>

</style>
