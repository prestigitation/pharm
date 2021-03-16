<template>
        <div>
            <b-form-group>
            <b-form-input
                v-model="form.company"
                placeholder="Введите название компании поставщика"
                required
                ></b-form-input>
            </b-form-group>

            <b-form-group>
                <b-form-input
                v-model="form.chief"
                placeholder="Введите ФИО владельца компании"
                required
                ></b-form-input>
            </b-form-group>

            <b-form-group>
                <b-form-input
                v-model="form.number"
                placeholder="Введите телефонный номер компании"
                required
                ></b-form-input>
            </b-form-group>
            <div class="text-center">
                <b-button type="submit" variant="primary">Отправить</b-button>
            </div>
    </div>
</template>

<script>
export default {
    data() { return {
        form : {
            company : '',
            chief : '',
            number : '',
        },
    }},

}
</script>

<style>

</style>
