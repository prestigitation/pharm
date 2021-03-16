<template>
<!-- TODO : Вывести миниатюры изображений в таблицу. -->
  <Section>
      <div slot="section_header">
          Филиалы Компании
      </div>

      <div slot="section_content">
              <b-table responsive :items="departments"  table-variant="primary" :fields="fields" variant="primary" class="text-center" @row-hovered="getLine">
                  <template #cell(actions)>
                    <b-icon-pencil-square role="button" variant="success" title="Редактировать" @click="showEditModal"></b-icon-pencil-square>
                    <b-icon-x role="button" variant="danger" title="Удалить" @click="showDeleteModal"></b-icon-x>
                </template>
                <template #cell(img)='data'>
                    <img :src="imgPath + data.item.id + '.jpeg'">
                </template>
              </b-table>
      </div>

      <b-modal id="edit">
         <div slot="modal-footer"></div>
        <Section>
        <div slot="section_header"> Обновление филиала </div>
        <div slot="section_content">
            <div> Введите новые данные о филиале : </div>
            <b-form id="form" >
                <departments-form @sendData='updateData'></departments-form>
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
  </Section>
</template>

<script>
import UpdateDeleteFunctions from './UpdateDeleteFunctions';
import DepartmentsForm from './DepartmentsForm.vue';
export default {
  components : { DepartmentsForm },
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
        let info = await axios.post('department_info');
        this.departments = info.data.departments;
        this.imgPath = "\\public\\storage\\img\\departments\\"; //info.data.storage_path + "\\storage\\img\\departments\\";

    },
    props : ['sendData'],
    methods : {
        updateData(event) {
            console.log(event);
            this.update({props : event.form, updatingId : this.other });
        }
    }
}

</script>

<style>

</style>
