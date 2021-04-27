<template>
  <b-form-group>
        <b-form-group>
            <b-form-input
            type="text"
            v-model="form.city"
            placeholder="Введите название города"
            class="my-2"></b-form-input>

            <b-form-input
            type="text"
            v-model="form.address"
            placeholder="Введите точный адрес филиала"
            class="my-2"></b-form-input>

            <div> Прикрепите файл </div>
            <b-form-file
            v-model="form.file"
            class="my-2"
            id="file"
            plain
            ref="file"></b-form-file>
        </b-form-group>

        <b-form-group>
            <b-form-input
            v-model="form.chief"
            type="text"
            placeholder="Введите ID Ответственного лица"
            > </b-form-input>
        </b-form-group>

        <div class="text-center">
            <b-button type="submit" @click.prevent='emitSubmit'> Отправить </b-button>
        </div>
  </b-form-group>
</template>

<script>
import UpdateDeleteFunctions from './UpdateDeleteFunctions.vue';
export default {
    extends : UpdateDeleteFunctions,
    data() {
        return {
            form : {
                file:this.file,
            }
        }
    },
    props : ['sendData','city','address','chief'],


}
</script>

<style>

</style>
