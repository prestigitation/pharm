<template>
    <div>

    <form id="logout-form" action="/logout" method="POST" style="display: none;">
    <input type="hidden" name="_token" :value="csrf">
</form>
  <b-navbar toggleable="lg" type="dark" variant="info">
    <b-navbar-brand href="/" class="lead">Pharm</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav>
            <b-nav-item href="#" class='text-center'>
                <router-link to="/filter">
                    Все медикаменты
                </router-link>
            </b-nav-item>
      </b-navbar-nav>

        <b-nav-form class="mr-auto text-center ml-auto">
          <b-form-input class="m-1" placeholder="Поиск" v-model="search"></b-form-input>
          <b-button class="m-1 mr-auto text-center ml-auto" @click.prevent='searchData' type="submit">Найти</b-button>
        </b-nav-form>

      <!-- Right aligned nav items -->
      <b-navbar-nav class="text-center m-1">
          <b-nav-item class="text-center">
              <router-link to="/cart">
                <b-iconstack class="mr-4 mt-0 align-middle text-center" >
                    <b-icon-circle shift-v="4.5" scale="1.3" class="align-middle">
                    </b-icon-circle>
                    <b-icon-cart4 scale="0.7" shift-v="4.5" ></b-icon-cart4>
                </b-iconstack>
              </router-link>
        </b-nav-item>
        <b-nav-item-dropdown class='text-center ml-auto mr-auto' right>
          <!-- Using 'button-content' slot -->
          <template #button-content>
            <em>Пользователь</em>
          </template>
            <b-dropdown-item  v-if="this.$store.getters.getAuth == true">
                <router-link :to="{ name: 'user_profile', params: { id: this.$store.getters.getAuthUser.userId } }">
                    Мой Профиль
                </router-link>
            </b-dropdown-item>
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
                    search : '',
            }
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
                    })/*.catch(function() {
                        window.location.reload();
                    })*/
                    .then( (response) => {
                        console.log(response);
                        this.$store.commit('authentificate',{ userId : response.data.user.id });
                        window.location.reload();
                    })
                    .catch(function () {
                        window.location.reload();
                    });
                },
                searchData() {
                    this.$router.push({name : 'filter',params: {name : this.search}})
                }
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
