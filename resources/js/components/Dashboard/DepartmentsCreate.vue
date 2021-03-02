<template>
    <Section>
        <slot name="section_header"><span> Создание филиала </span> </slot>
        <slot name="section_body">
            <div> Введите данные о новом филиале : </div>
            <b-form @submit.prevent="departmentCreate">
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
                    plain
                    ref="file"></b-form-file>
                </b-form-group>

                <b-button type="submit"> Отправить </b-button>

            </b-form>
        </slot>
    </Section>
</template>

<script>
import Section from './Section'
export default {
    data : function() {
        return {
            form: {
                file : this.file,
                city : '',
                adress : '',
            },

        }
    },
    methods : {
        departmentCreate() {
            //this.file = this.$refs.file.files[0];
            let formData = new FormData();
            formData.append('formProps', JSON.stringify(this.form));
            formData.append('formFile', this.form.file);
            axios({
                method: 'post',
                url: 'create',
                headers : { 'Content-Type' : 'multipart/form-data'},
                data: formData ,
                })
                .then((response) => {
                   this.$bvToast.toast('Филиал был успешно создан', { title : 'Создание филиала', variant:'success' })
                })
                .catch(() => {
                    // уведомление
                    this.$bvToast.toast('Неправильные параметры запроса', { title : 'Пользовательские данные'});
                })
        }
    }
}


</script>


<style>



</style>
