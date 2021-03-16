<template>
    <Section>
        <div slot="section_header"> Роли пользователей </div>
        <div slot="section_content">
            <span> Доступные роли : </span>
            <span v-for="role in roles" :key="role">
                {{ role.name }},
            </span>

            <div class='w-50 mr-auto ml-auto m-3 d-flex flex-direction-column justify-content-center'>
                Вы можете добавить роль :
                <b-form
                @submit.prevent="createData({props:JSON.stringify(event.form), file : event.form.file });"
                >
                    <b-form-input
                    type="text"
                    placeholder="Введите имя"
                    v-model="newRole"
                    >
                    </b-form-input>
                    <b-button
                    class="m-2"
                    type="submit"
                    variant="success">
                    Отправить
                    </b-button>
                </b-form>
            </div>
        </div>
    </Section>
</template>

<script>
import Section from './Section';
import UpdateDeleteFunctions from './UpdateDeleteFunctions';
export default {
    data() {
        return {
            roles : '',
            newRole : '',
        }
    },
    async mounted() {
        let info = await axios.post('get');
        this.roles = info.data.roles;
    }
}
</script>

<style>

</style>
