<template>
    <Section>
        <div slot="section_header" class="lead text-center m-4"> Роли и права пользователей </div>
        <div slot="section_content">
                <div class="d-inline-block mr-5">
                    <b-table
                    table-variant="primary"
                    head-variant="warning"
                    head-row-variant="warning"
                    :items="roles"
                    :per-page="perPage"
                    :current-page="currentRolesPage"
                    :fields="roles_fields"
                    @row-hovered="getLine"
                    class="text-center flex-direction-column"
                    id="roles_table"
                    >
                    <template #cell(id)="data">
                        {{ data.index + 1 }}
                    </template>
                    <template #cell(name)="data">
                        {{ data.value }} <b-icon-info-circle-fill role="button" @click="showRolePermissions"></b-icon-info-circle-fill>
                    </template>

                    </b-table>
                    <b-pagination
                    class="d-flex justify-content-center"
                    aria-controls="roles_table"
                    v-model="currentRolesPage"
                    :per-page="perPage"
                    :total-rows="roles.length"
                    >
                    </b-pagination>
                </div>

                <div class="d-inline-block ml-5">
                    <b-table
                    :items="permissions"
                    table-variant="primary"
                    head-variant="warning"
                    head-row-variant="warning"
                    :per-page="perPage"
                    :current-page="currentPermissionsPage"
                    :fields="permissions_fields"
                    class="text-center flex-direction-column"
                    id="permissions_table"
                    >
                    </b-table>
                    <b-pagination
                    class="d-flex justify-content-center"
                    aria-controls="permissions_table"
                    v-model="currentRolesPage"
                    :per-page="perPage"
                    :total-rows="permissions.length"
                    >
                    </b-pagination>
                </div>
            <div class="d-inline-block">
                <div class='w-50 mr-auto ml-auto m-3 d-flex flex-direction-row justify-content-center'>
                Вы можете добавить роль
                <b-form
                @submit.prevent="createData({ props : JSON.stringify(newRole), file : null });"
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

            <div class='w-50 mr-auto ml-auto m-3 d-flex flex-direction-row justify-content-center'>
                Вы можете добавить право доступа
                <b-form
                @submit.prevent="addPermission"
                >
                    <b-form-input
                    type="text"
                    placeholder="Введите имя"
                    v-model="newPermission"
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

            <div class=' mr-auto ml-auto m-3 d-flex flex-column align-content-center'>

                <div class="d-flex flex-column align-items-center">
                    Вы можете установить роль определенному пользователю или удалить существующую
                </div>

                <div class="d-flex flex-column align-items-center">
                    Пользователь : {{ attachingUser.name || 'Не найдено' }},
                </div>
                <div class="d-flex flex-row justify-content-center">
                    Роли  :
                    <span v-for="role in attachingUserRoles" :key="role.name">
                        <b-badge class="m-1" variant="warning"> {{ role.name }}
                            <b-icon-x role="button" @click="userRoleDetach"> </b-icon-x>
                        </b-badge>
                    </span>
                </div>

                <b-form
                @submit.prevent="userRoleAttach"
                class="w-20 ml-auto mr-auto"
                >
                    <b-form-input
                    type="text"
                    class="text-center"
                    placeholder="Введите ID"
                    v-model="newRolePermission"
                    @input="getUserInfo"
                    >
                    </b-form-input>
                    <b-form-select v-model="addingUserRole" class="text-center">
                        <b-form-select-option @select="getRole"  class="text-center"
                         v-for="(role_id,role_name) in roles"
                         :key="role_id"
                         :value="role_name"
                         >
                            {{ role_id.name }}
                        </b-form-select-option>
                    </b-form-select>
                    <b-button
                    class=" d-flex mt-2 mr-auto ml-auto w-50 justify-content-center"
                    type="submit"
                    variant="success">
                    Отправить
                    </b-button>
                </b-form>

            </div>
        </div>
    <b-modal id="role_permissions"  hide-footer>
        <div>
            <div> Список прав {{ other }} : </div>
            <b-badge class="d-inline-block m-1" v-for="permission in rolePermissions" :key="permission" >
                    {{ permission.name }} <b-icon-x role="button" @click="detachPermission"></b-icon-x>
            </b-badge>
            <div> Добавить право : </div>
            <b-form>
                <b-form-select v-model="addingPermission">
                    <option v-for="permission in permissions" :key="permission">
                        {{ permission.name }}
                    </option>
                </b-form-select>
            </b-form>
           <b-card role="button" class="text-center w-50 mr-auto ml-auto m-2" @click="attachPermissionToRole"  bg-variant="info">
               Привязать
            </b-card>
        </div>
    </b-modal>
    </Section>
</template>

<script>
import Section from './Section';
import UpdateDeleteFunctions from './UpdateDeleteFunctions';
export default {
    components : Section,
    extends : UpdateDeleteFunctions,
    data() {
        return {
            roles : '',
            permissions : '',
            newRole : '',
            newPermission:'',
            newRolePermission:'',
            rolePermissions:'',
            attachingUser:'',
            attachingUserRoles:'',
            addingUserRole : '',
            other : '',
            addingPermission:'',
            roles_fields: [
                { key : 'id', label : 'ID'},
                { key : 'name', label : 'Название роли'},
            ],
            permissions_fields: [
                { key : 'name', label : 'Название права'},
            ],
            currentRolesPage : 1,
            currentPermissionsPage : 1,
            perPage : 5,
        }
    },
    props : ['other','addingUserRole'],
    methods : {
        async showRolePermissions() {
            let rolePermissionPromise = await axios.get('/api/roles/' + this.other + '/permissions');
            this.rolePermissions = rolePermissionPromise.data;
            this.$bvModal.show('role_permissions');
        },
        getLine(event) {
            this.other = event.name;
        },
        attachPermissionToRole() {
            let data = new FormData();
            data.append('selectedPermission',this.addingPermission);
            axios.post('/api/roles/' + this.other + '/permissions',data);
        },
        detachPermission(event) {
            let deletingPermission = event.target.parentElement.firstChild.data.substring(1).trim();
            // перед текстом в компоненте идет сначала \n, а потом ненужные пробелы, удаляем их
            let formData = new FormData();
            formData.append('deletingPermission', deletingPermission);
            axios.delete('/api/roles/' + this.other + '/permissions',{
                data : {
                deletingPermission : formData.get('deletingPermission')
                }
            });
        },
        async getUserInfo(event) {
            let user = await axios.get('/api/users/' + event);
            this.attachingUser = user.data;
            let userRoles = await axios.get('/api/users/' + event + '/roles');
            this.attachingUserRoles = userRoles.data;
            console.log(userRoles.data);
        },
        async addPermission() {
            let formData = new FormData();
            formData.append('addingPermission',this.newPermission);
            axios.post('/api/permissions',formData);
        },
        async userRoleAttach(event) {
            let formData = new FormData();
           // let attachingPermission = event.target.parentElement.firstChild.data.substring(1).trim();
            formData.append('attachingRole',this.addingUserRole + 1); // +1 , т.к в базе индексы хранятся с 1 позиции
            axios.post('/api/users/' + this.attachingUser.id + '/roles',{data: {attachingRole : formData.get('attachingRole')}});
        },
        async userRoleDetach(event) {
            let formData = new FormData();
            let detachingPermission = event.target.parentElement.firstChild.data.substring(1).trim();
            console.log(event);
            formData.append('detachingRole',detachingPermission);
            axios.delete('/api/users/' + this.attachingUser.id + '/roles',{data: {deletingRole : formData.get('detachingRole')}});
        },
        getRole(event) {
            console.log(event);
        }
    },
    async mounted() {
        let rolesPromise = await axios.get('/api/roles')
        let permissionsPromise = await axios.get('/api/permissions');
        this.roles = rolesPromise.data;
        this.permissions = permissionsPromise.data;
    },
}
</script>

<style>

</style>
