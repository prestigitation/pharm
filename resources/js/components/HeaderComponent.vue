<template>
    <div>

    <form id="logout-form" action="/logout" method="POST" style="display: none;">
    <input type="hidden" name="_token" :value="csrf">
</form>
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
            <b-dropdown-item  v-if="this.$store.getters.getAuth == true"> <router-link :to="{ name: 'user_profile', params: { id: this.$store.getters.getAuthUser } }"> Мой Профиль </router-link> </b-dropdown-item>
            <b-dropdown-item @click="$bvModal.show('login')" v-if="this.$store.getters.getAuth == false" >Войти</b-dropdown-item>
            <b-dropdown-item @click="$bvModal.show('register')"  v-if="this.$store.getters.getAuth == false">Зарегистрироваться</b-dropdown-item>
            <b-dropdown-item @click="logout" v-if="this.$store.getters.getAuth == true">Выйти</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>


<notifications group="alert" width="355" position="bottom right" />

<b-modal id="login" hide-footer>
   <div class="modal-container">

              <div class="modal-header">
                  Войти
              </div>

              <div class="modal-body">
                  <b-form @submit.prevent='loginUser'>
                    <b-form-input
                        id="input-1"
                        v-model="login"
                        type="text"
                        placeholder="Логин:"
                        required
                        ></b-form-input>

                        <b-form-input
                        id="input-2"
                        type="password"
                        v-model="password"
                        placeholder="Пароль:"
                        required
                        ></b-form-input>
                    <b-button class="d-flex align-items-center" type="submit" variant="primary" id="submit">Отправить</b-button>
                </b-form>
              </div>
            </div>
  </b-modal>



  <b-modal id="register" hide-footer>
   <div class="modal-container">

              <div class="modal-header">
                  Регистрация
              </div>

              <div class="modal-body">

                  <b-form class="d-flex flex-column" @submit.prevent='registerUser'>

                        <b-form-input
                        id="input-1"
                        v-model="login"
                        type="text"
                        placeholder="Имя пользователя:"
                        required
                        ></b-form-input>

                        <b-form-input
                        id="input-2"
                        type="password"
                        v-model="password"
                        placeholder="Введите пароль:"
                        required
                        ></b-form-input>

                        <b-form-input
                        id="input-4"
                        v-model="email"
                        type="email"
                        placeholder="Введите e-mail:"
                        required
                        ></b-form-input>
                    <b-button class="d-flex align-items-center " type="submit" variant="primary" id="submit">Зарегистрироваться</b-button>
                </b-form>


              </div>
            </div>
  </b-modal>
</div>
</template>



<script>
    export default {
        data : function() {
            return {
                    login: '',
                    password: '',
                    email:'',
                    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    generalError:'',
            }
        },

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

        },
        methods : {
                logout() {
                    axios.post('auth/logout')
                        .then(() => {
                            this.$store.commit('logout');
                            window.location.reload();
                        });
                },

                loginUser() {
                    axios({
                    method: 'post',
                    url: 'auth/login',
                    data:{ login:this.login,password:this.password },
                    }).catch(function(response) {
                        window.location.reload();
                    })
                    .then( (response) => {
                        this.$store.commit('authentificate', response.data.user.id)
                        window.location.reload();
                    })
                    .catch(function (response) {
                    console.log(response)
                    });
                },
                registerUser() {
                    axios({
                    method: 'post',
                    url: 'auth/register',
                    data:{ login:this.login,password:this.password, email :this.email },
                    }).catch(function(response) {
                        window.location.reload();
                    })
                    .then( (response) => {
                        this.$store.commit('authentificate', response.data.user.id)
                        window.location.reload();
                    })
                    .catch(function (response) {
                    console.log(response)
                    });
                },
        },

        computed : {
            user_links() {
                return '/users' + this.$store.getters.getAuthUser;
            }
        }


    }
</script>

<style>
    #input-1,
    #input-2,
    #input-3,
    #input-4,
    #submit {
        margin: 10px;
    }

</style>
