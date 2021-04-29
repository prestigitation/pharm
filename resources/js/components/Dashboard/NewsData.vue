<template>
  <div>
      <div>
          <b-table :items="allNews" :fields="fields" table-variant="info" class="text-center" @row-hovered="getLine">
                <template #cell(actions)>
                    <b-icon-pencil-square role="button" variant="success" title="Редактировать" @click="showEditModal"></b-icon-pencil-square>
                    <b-icon-x role="button" variant="danger" title="Удалить" @click="showDeleteModal"></b-icon-x>
                </template>
            </b-table>
            <b-card role="button" class="text-center lead w-50 mr-auto ml-auto" bg-variant="info"  @click="showCreateModal"> Добавить <b-icon-plus-circle> </b-icon-plus-circle> </b-card>
      </div>
      <b-modal id="create" hide-footer>
          <span> Вы можете добавить новость : </span>
          <news-form @sendData="handeAddEvent"></news-form>
      </b-modal>
      <b-modal id="edit" hide-footer>
          <news-form @sendData="handleUpdateEvent"></news-form>
      </b-modal>
      <b-modal id="delete" hide-footer>
          <span> Вы действительно хотите удалить запись?</span>
          <b-button variant='danger' class="w-25 mr-auto ml-auto m-2" @click.prevent='deleteData'> Удалить </b-button>
      </b-modal>
  </div>
</template>

<script>
import NewsForm from './NewsForm.vue';
import UpdateDeleteFunctions from './UpdateDeleteFunctions';
export default {
    components : NewsForm,
    extends : UpdateDeleteFunctions,
    data() {
        return {
            allNews : '',
            fields : [
                    { key : 'id', label : 'ID новости'},
                    { key : 'title', label : 'Заголовок'},
                    { key : 'content', label : 'Содержание'},
                    { key: 'created_at',label: 'Добавлено'},
                    { key: 'actions',label: 'Действия'},
                ],
            other : '',
        }
    },
    props : ['sendData'],
    async mounted() {
        await axios.get('/api/news').then(result => {
            this.allNews = result.data
        })
    }
}
</script>

<style>

</style>
