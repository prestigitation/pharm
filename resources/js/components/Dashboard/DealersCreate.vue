<template>
    <Section>
        <div slot="section_header"> Поставщики </div>
        <div slot="section_content">
            <div class="text-center mb-2"> Добавить поставщика :</div>
            <b-form @submit.prevent="createData(JSON.stringify(form))" class="w-100 mr-auto ml-auto">
                <dealer-form> </dealer-form>
            </b-form>
        </div>
    </Section>
</template>

<script>
import UpdateDeleteFunctions from './UpdateDeleteFunctions';
import Section from './Section.vue';
import DealerForm from './DealerForm.vue';
    export default {
  components: { Section, DealerForm },
  extends : { UpdateDeleteFunctions },
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
}
</script>
