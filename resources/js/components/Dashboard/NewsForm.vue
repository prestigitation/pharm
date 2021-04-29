<template>
  <b-form>
        <b-form-input
        class="my-2"
        type="text"
        v-model="form.title"
        placeholder="Заголовок новости"
        ></b-form-input>
        <b-form-textarea class="my-2" v-model="form.content"></b-form-textarea>
        <b-form-file v-model="form.file" placeholder="Прикрепите скриншот"></b-form-file>
        <b-button @click.prevent='emitSubmit' type="submit" class="d-flex w-50 justify-content-center mr-auto ml-auto mt-2" variant="success"> Отправить </b-button>
    </b-form>
</template>

<script>
import UpdateDeleteFunctions from './UpdateDeleteFunctions.vue'
export default {
    extends : UpdateDeleteFunctions,
    data() {
        return {
            form: {
                file: '',
                title: '',
                content:'',
            },
        }
    },
    props:['title','content','sendData']
}
</script>

<style>

</style>
