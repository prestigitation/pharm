<template>
    <Section>
        <slot name="section_header"><span> Создание филиала </span> </slot>
        <slot name="section_body">
            Введите данные о новом филиале :
            <b-form @submit.prevent="departmentCreate">
                <b-form-group>
                    <b-form-input
                    type="text"
                    v-model="city"
                    required
                    placeholder="Введите название города"
                    class="my-2"></b-form-input>

                    <b-form-input
                    type="text"
                    v-model="address"
                    required
                    placeholder="Введите точный адрес филиала"
                    class="my-2"></b-form-input>

                    <div> Прикрепите файл </div>
                    <b-form-file
                    required
                    class="my-2"
                    plain></b-form-file>
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
                city : '',
                adress : '',
        }
    },
    methods : {
        departmentCreate() {
            axios({
                method: 'post',
                url: 'create',
                data: {
                    city : this.city,
                    address : this.address,
                } ,
                })
                .then((response) => {
                   console.log(response);
                })
                .catch((error) => {
                    // уведомление
                    this.$bvToast.toast('Неправильные параметры запроса', { title : 'Пользовательские данные'});
                })
        }
    }
}


</script>


<style>



</style>
