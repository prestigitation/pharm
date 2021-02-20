<template>
  <div class="w-50 mr-auto ml-auto mt-3">
    <b-form @submit="onSubmit" @reset="onReset" v-if="show" id="myform">
      <div class="m-2">

        <b-form-file  class="mt-3"
        v-model="form.file"
        placeholder="Загрузите изображение товара..."
        drop-placeholder="Drop file here..."
        accept=".jpg, .png"
        required></b-form-file>
    </div>


      <b-form-group id="input-group-1" label="Добавить медикамент:" label-for="input-1">
        <b-form-input
          id="input-1"
          v-model="form.name"
          placeholder="Введите название медикамента"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-2" label="Категория:" label-for="input-2">
        <b-form-select
          id="input-2"
          v-model="form.categories"
          required
        >
            <option v-for="category in categories" :key='category'>
                {{ category.name }}
            </option>
        </b-form-select>
      </b-form-group>

       <b-form-group id="input-group-3" label="Противопоказания:" label-for="input-3">
            <b-form-textarea
            id="textarea1"
            v-model="form.contraindications"
            placeholder="Введите противопоказания (если есть)"
            rows="3"
            max-rows="6"
            >
            </b-form-textarea>
       </b-form-group>

        <b-form-group id="input-group-4" label="Цена:" label-for="input-4">
            <b-form-input
            id="input-4"
            v-model="form.price"
            placeholder="Введите цену продажи (за 1ед. товара)"
            required
            >
            </b-form-input>
      </b-form-group>

      <b-form-group id="input-group-5" label="Описание:" label-for="input-5">
            <b-form-textarea
            id="textarea2"
            v-model="form.description"
            placeholder="Введите описание медикамента"
            required
            rows="3"
            max-rows="6"
            >
            </b-form-textarea>
       </b-form-group>


        <div class="text-center">
            <b-button type="submit" variant="primary" class="m-2">Отправить</b-button>
            <b-button type="reset" variant="danger" class="m-2">Сбросить</b-button>
        </div>

    </b-form>


  </div>


</template>

<script>

const axios = require('axios');
import  { sessionStore,sessionClear } from '../app';
  export default {
    data() {
      return {
        form: {
          file: this.file,
         // name: '',
         // categories:this.categories.id,
        },
        show: true,
      }
    },
    props: ['categories','description','contraindications'],
    methods: {
      onSubmit(event) {
          event.preventDefault();
          let formData = new FormData();
          formData.append('formProps', JSON.stringify(this.form));
          formData.append('formFile', this.form.file);
         axios({
            method: 'post',
            url: 'create',
            data: formData,
            headers: {'Content-Type': 'multipart/form-data' }
            })
            .then(function (response) {
               window.location.replace('/');
               //sessionClear();
               sessionStore('success','Добавление товара', 'Медикамент был успешно добавлен');

            })
            .catch(function (response) {
                window.location.replace('/product/create');
                sessionStore('error','Добавление товара', 'Форма не была отправлена. Укажите корректные данные');
            });

            },
      onReset(event) {
        event.preventDefault()
        this.form.contraindications = ''
        this.form.description = ''
        this.form.categories = '';
        this.form.name = ''
        this.price = ''
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      },
    },
  }
</script>
