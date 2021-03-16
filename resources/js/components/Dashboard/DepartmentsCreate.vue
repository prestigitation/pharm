<template>
    <Section>
        <div slot="section_header"> Создание филиала </div>
        <div slot="section_content">
            <div> Введите данные о новом филиале : </div>
            <b-form>
                <departments-form @sendData="addData" ></departments-form>
            </b-form>
        </div>
    </Section>
</template>

<script>
import Section from './Section';
import UpdateDeleteFunctions from './UpdateDeleteFunctions';
import DepartmentsForm from './DepartmentsForm.vue';
export default {
    components: { Section, DepartmentsForm },
    extends :   UpdateDeleteFunctions  ,
    props : ['sendData','form'],
    methods : {
        addData(event) {
            this.createData({props:JSON.stringify(event.form), file : event.form.file });
        }
    }
}

</script>


<style>



</style>
