<template>
    <Section>
        <slot name="section_header"><span> Создание филиала </span> </slot>
        <slot name="section_body">
            <div> Введите данные о новом филиале : </div>
            <b-form id="form" @submit.prevent="departmentsCreate">
                <b-form-group>
                    <b-form-input
                    type="text"
                    v-model="form.city"
                    required
                    placeholder="Введите название города"
                    class="my-2"></b-form-input>

                    <b-form-input
                    type="text"
                    v-model="form.address"
                    required
                    placeholder="Введите точный адрес филиала"
                    class="my-2"></b-form-input>

                    <div> Прикрепите файл </div>
                    <b-form-file
                    v-model="form.file"
                    required
                    class="my-2"
                    id="file"
                    plain
                    ref="file"></b-form-file>
                </b-form-group>

                <b-button type="submit"> Отправить </b-button>
            </b-form>
        </slot>
    </Section>
</template>

<script>
import { mapActions } from 'vuex'
import Section from './Section'
export default {
    data : function() {
        return {
            form: {
                file : this.file,
            },

        }
    },
    props : ['city', 'address'],
    methods : {
        ...mapActions([
      'sendQuery'
    ]),
        async departmentsCreate() {
            let formFile = new FormData();
            formFile.append('props', JSON.stringify(this.form));
            formFile.append('files', this.form.file);
            console.log(formFile);
            // TODO форма отдельно, файлы отдельно
            this.$store.dispatch('sendQuery', formFile);
        }
    },
}


</script>


<style>



</style>
