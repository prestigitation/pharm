<template>
<div>
    <span class="m-2">Введите имя пользователя, по которому вы хотите получить информацию: </span>

    <b-form-input v-model="username" class="my-2"></b-form-input>
    <b-button class="btn btn-primary my-2" @click.prevent='userGet'> Найти </b-button>
</div>
</template>


<script>
import Section from './Section';
export default {
    data : function() {
        return {
            username : '',
        }
    }
}
</script>
