<template>
    <Section>
        <div slot="section_header"></div>
        <div slot="section_content">
            <b-table :items="dealers" :fields="fields" table-variant="info" class="text-center" @row-hovered="getLine">
                <template #cell(actions)>
                    <b-icon-pencil-square role="button" variant="success" title="Редактировать" @click="showEditModal"></b-icon-pencil-square>
                    <b-icon-x role="button" variant="danger" title="Удалить" @click="showDeleteModal"></b-icon-x>
                </template>
            </b-table>
            <b-card role="button" class="text-center lead w-50 mr-auto ml-auto" bg-variant="info"  @click="showCreateModal"> Добавить <b-icon-plus-circle> </b-icon-plus-circle> </b-card>


      <b-modal id="edit">
            <div slot="modal-footer"></div>
            <div class="text-center mb-2"> Изменить информацию о поставщике :</div>

            <b-form class="w-50 mr-auto ml-auto">
                <dealer-form @sendData='handleUpdateEvent'></dealer-form>
            </b-form>
      </b-modal>

      <b-modal id="delete">
            <div slot="modal-footer"></div>
            <div> Вы действительно хотите удалить филиал из списка? </div>
            <div class="text-center m-2">
                <b-button type="submit" @click.prevent="deleteData" variant="success">  Да </b-button>
                <b-button type="submit" @click.prevent="closeDeleteModal" variant="danger"> Отмена </b-button>
            </div>
      </b-modal>

      <b-modal id="create">
          <div slot="modal-footer"></div>
          <b-form class="w-100 mr-auto ml-auto">
                <dealer-form @sendData="handeAddEvent"> </dealer-form>
            </b-form>
      </b-modal>
    </div>
    </Section>
</template>

<script>
import Section from './Section';
import UpdateDeleteFunctions from './UpdateDeleteFunctions';
import DealerForm from './DealerForm.vue';
export default {
  components: { Section,DealerForm },
  extends : UpdateDeleteFunctions,
        data: function() {
            return {
                fields : [
                    { key : 'company', label : 'Название компании'},
                    { key : 'chief', label : 'ФИО руководителя'},
                    { key : 'number', label : 'Контактный номер'},
                    { key: 'actions',label: 'Действия'}
                ],

            }
        },
    props :['dealers','sendData'],
        async mounted() {
            let result = await this.getData();
            this.dealers = result.data;
        },
}
</script>

<style>

</style>
