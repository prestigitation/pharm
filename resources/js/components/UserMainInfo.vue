<template>
<div>
       <header-component></header-component>
        <div class="d-flex justify-content-center align-items-center">
            <div class="d-flex flex-column justify-content-center align-items-center mx-5 mt-3">
                <h1 class="lead">
                    Страница профиля
                </h1>
            <b-form enctype="multipart/form-data">
                <b-form-group>
                    <span> Логин : </span>
                    <b-form-input :placeholder="user.name" v-model="editedName"/>
                </b-form-group>
                <b-form-group>
                    <span> E-mail : </span>
                    <b-form-input :placeholder="user.email" v-model="editedEmail"/>
                </b-form-group>
                <b-form-group>
                    <span> Пароль : </span>
                    <b-form-input v-model="editedPassword" placeholder="Введите новый пароль"/>
                </b-form-group>
                <b-form-group>
                    <b-form-input v-model="previousPassword" placeholder="Введите текущий пароль"/>
                </b-form-group>
                <b-button type="submit" variant='success' @click.prevent='changeUserData'> Отправить данные </b-button>
                </b-form>
            </div>
                <div class="d-flex flex-column justify-content-center align-items-center mx-5">
                    <img :src="'/storage/img/avatars/' + $route.params.id  + '.jpeg'" v-if="hasAvatar == true">
                    <img v-else src="/storage/img/avatars/default.jpg" width="300" height="300">
                    <b-form-group label-for="file">
                        <b-form-file
                        v-model="file"
                        id="file"
                        name="file"
                        :state="Boolean(file)">
                        </b-form-file>
                    </b-form-group>
                </div>
        </div>
</div>
</template>

<script>
import UpdateDeleteFunctions from './Dashboard/UpdateDeleteFunctions'
export default {
    extends : UpdateDeleteFunctions,
    data() {
        return {
            user : '',
            previousPassword : '',
            editedName : '',
            editedEmail : '',
            editedPassword : '',
            editedAvatar : '',
        }
    },
    props : ['userAvatar','hasAvatar','file'],
    async mounted() {
        let {userId} = this.$store.getters.getAuthUser
        await axios.get('/api/users/' + userId).then(result => {
            let {data} = result
            this.user = data
        })
        await axios.get('/storage/img/avatars/' + this.$route.params.id + '.jpeg').then(result => {
            this.hasAvatar = true
        }).catch(()=> {
            this.hasAvatar = false
        })
    },
    methods : {
        async changeUserData() {
            let props = {
                previousPassword:this.previousPassword,
                editedName : this.editedName,
                editedPassword:this.editedPassword,
                editedEmail : this.editedEmail,
            }
            let form = new FormData()
            let file = this.file
            console.log(file)
            form.append('props',JSON.stringify(props))
            form.append('file',this.file)
            form.append('_method','put')
            await axios.post('/api/users/' + this.$store.getters.getAuthUser.userId,form,{
                'Content-Type': 'multipart/form-data'
            }).then(result => {
                console.log(result)
            }).catch(()=> {
                console.log('fail')
            })
        }
    }
}
</script>

<style>

</style>
