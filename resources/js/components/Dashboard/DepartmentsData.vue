<template>
<!-- TODO : Вывести миниатюры изображений в таблицу. -->
  <Section>
      <div slot="section_header">
          Филиалы Компании
      </div>

      <div slot="section_content">
              <b-table responsive :items="departments"  table-variant="primary" :fields="fields" variant="primary" class="text-center align-items-center d-flex" @row-hovered="getLine">
                  <template #cell(actions)>
                    <b-icon-pencil-square role="button" variant="success" title="Редактировать" @click="showEditModal"></b-icon-pencil-square>
                    <b-icon-x role="button" variant="danger" title="Удалить" @click="showDeleteModal"></b-icon-x>
                </template>
                <template #cell(img)='data'>
                    <img :src="'/storage/img/departments/' + (data.item.id + 1) + '.jpeg'" id="department_img">
                </template>
              </b-table>
              <b-card role="button" class="text-center lead w-50 mr-auto ml-auto" bg-variant="info"  @click="showCreateModal"> Добавить <b-icon-plus-circle> </b-icon-plus-circle> </b-card>
      </div>

      <b-modal id="edit">
         <div slot="modal-footer"></div>
        <Section>
        <div slot="section_header"> Обновление филиала </div>
        <div slot="section_content">
            <div> Введите новые данные о филиале : </div>
            <b-form id="form" >
                <departments-form @sendData='handleUpdateEvent'></departments-form>
            </b-form>
        </div>
        </Section>
      </b-modal>

      <b-modal id="delete">
          <!--  очистить модал от кнопки ок и отмена -->
          <div slot="modal-footer"></div>
          <div> Вы действительно хотите удалить филиал из списка? </div>
          <div class="text-center m-2">
              <b-button type="submit" @click.prevent="deleteData" variant="success">  Да </b-button>
              <b-button type="submit" @click.prevent="closeDeleteModal" variant="danger"> Отмена </b-button>
          </div>
      </b-modal>

      <b-modal id="create">
          <departments-form @sendData='handeAddEvent'></departments-form>
      </b-modal>
  </Section>
</template>

<script>
import UpdateDeleteFunctions from './UpdateDeleteFunctions';
import DepartmentsForm from './DepartmentsForm.vue';
export default {
  components :  DepartmentsForm ,
  extends : UpdateDeleteFunctions,
    data : function() {
        return {
            departments : '',
            fields : [
                { key : 'img', label : 'Изображение'},
                { key : 'city', label : 'Город' },
                { key : 'address', label : 'Точный адрес'},
                { key : 'chief', label : 'ID ответственного'},
                { key : 'created_at', label : 'Создан' },
                { key : 'actions', label : 'Действия' }
            ],
            other : '',
        }
    },
    async mounted() {
        let departmentPromise = await this.getData();
        this.departments = departmentPromise.data;
      //  this.imgPath = "\\public\\storage\\img\\departments\\"; //info.data.storage_path + "\\storage\\img\\departments\\";

    },
    props : ['sendData'],
}

</script>

<style>
    #department_img {
        width: 50px;
        height: 50px;
    }
</style>
