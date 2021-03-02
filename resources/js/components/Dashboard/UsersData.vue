<template>
    <Section>
        <slot name="section_header"> <span> Информация о пользователе  </span> </slot>

        <slot name="section_content">
            <div>Введите имя пользователя, по которому вы хотите получить информацию: </div>

            <b-form-input v-model="username" class="my-2"></b-form-input>
            <b-button class="btn my-2" @click.prevent='userGet'> Найти </b-button>


            <b-card bg-variant="primary" text-variant="white" :header="'Пользователь :' + userData.name" class="text-center" v-if="userData">
                <b-card-text> ID : {{ userData.id }}</b-card-text>
                <b-card-text> Адрес электронной почты : {{ userData.email }}</b-card-text>
                <b-card-text> Дата регистрации : {{ userData.created_at }}</b-card-text>
            </b-card>
        </slot>
    </Section>
</template>

<script>
import Section from './Section';
    export default {
        data :function() {
            return {
                username : '',
            }

        },
        props: ['userData'],
        methods : {
            userGet() {
                axios({
                    method: 'post',
                    url: 'data',
                    data: { username : this.username } ,
                    })
                    .then((response) => {
                        this.userData = response.data.user[0]; // получить пользователя
                    })
                    .catch((error) => {
                        // уведомление
                        this.$bvToast.toast('Неправильные параметры запроса', { title : 'Пользовательские данные'});
                    })
                },
        },
        watched: {
            userData : () => {
                return response.data.user[0];
            }
        },
}
</script>
