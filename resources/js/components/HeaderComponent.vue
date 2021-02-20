<template>
    <div>
  <b-navbar toggleable="lg" type="dark" variant="info">
    <b-navbar-brand href="/" class="lead">PharmCrm</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav>
        <b-nav-item href="#" class='text-center'>Все медикаменты</b-nav-item>
      </b-navbar-nav>

        <b-nav-form class="mr-auto text-center ml-auto">
          <b-form-input class="m-1" placeholder="Поиск"></b-form-input>
          <b-button class="m-1 mr-auto text-center ml-auto" type="submit">Найти</b-button>
        </b-nav-form>

      <!-- Right aligned nav items -->
      <b-navbar-nav>
        <b-nav-item-dropdown class='text-center ml-auto mr-auto' right>
          <!-- Using 'button-content' slot -->
          <template #button-content>
            <em>Пользователь</em>
          </template>
          <b-dropdown-item href='/user/' v-if="auth" id="user"> Мой профиль </b-dropdown-item>
          <b-dropdown-item href="/login" v-if="!auth">Войти</b-dropdown-item>
          <b-dropdown-item href="/register" v-if="!auth">Зарегистрироваться</b-dropdown-item>
          <b-dropdown-item @click="logout" v-if="auth">Выйти</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>


<notifications group="alert" width="355" position="bottom right" />

</div>


</template>



<script>
    export default {
        mounted() {
            if(sessionStorage.getItem('status') != undefined && sessionStorage.getItem('title') != undefined && sessionStorage.getItem('message') != undefined) {
                this.$notify({
                group: 'alert',
                type: sessionStorage.getItem('status'),
                title: sessionStorage.getItem('title'),
                text: sessionStorage.getItem('message'),
                duration : 10000,
                });

                setTimeout(sessionStorage.clear(),10000);
            } // показ уведомлений

            document.getElementById('user').href+= this.$attrs.users.id; // создать ссылку, ведущую на id пользователя
        },
        methods : {
            logout() {
                axios.post('/logout')
            .then( () => {
                window.location.replace('/');
                });
            },
        },
        computed : {
            auth() {
                if(this.$attrs.users != null) { // см. view
                    return true;
                } else return false;
            }
        }

    }
</script>
