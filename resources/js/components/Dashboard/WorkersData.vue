<template>
  <div>
      <div> Вы можете нанять работника </div>
      <div> Пользователь : {{ userName || '' }} </div>
      <div>
          <b-form @submit.prevent="hireWorker(form.department[0])">
              <b-form-input type="text"
              placeholder="Введите ID пользователя"
              v-model="form.user"
              @change="getUser"
              class="my-2"
              ></b-form-input>
              <b-form-select v-model="form.department" class="my-2">
                  <option v-for="(department,index) in departments" :key="index">
                      {{ department.id + '.' + department.city + " " +  department.address }}
                  </option>
              </b-form-select>
              <b-form-input type="text" v-model="form.salary" placeholder="Введите оклад работника"></b-form-input>
              <b-button type="submit" class="d-flex mr-auto ml-auto my-2" > Отправить</b-button>
          </b-form>
      </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            form : {
                user : '',
                department : '',
            },
            departments : '',
        }
    },
    props : ['userName'],
    async mounted() {
        let {data} = await axios.get('/api/departments')
        this.departments = data
    },
    methods : {
        async getUser() {
            let {data} = await axios.get('/api/users/' + this.form.user)
            this.userName = data.name
        },
        hireWorker(departmentId) {
            let formData = new FormData()
            formData.append('department', departmentId)
            formData.append('user', this.form.user)
            formData.append('salary',this.form.salary)
            axios.post('/api/workers', formData)
        }
    }
}
</script>

<style>

</style>
