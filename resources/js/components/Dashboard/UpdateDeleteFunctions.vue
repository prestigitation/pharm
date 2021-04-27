<template>

</template>

<script>
export default {
    methods: {
        prepareRequest(props) {
            let formFile = new FormData();
            formFile.append('props', JSON.stringify(props.props));
            formFile.append('file', props.file);
            return formFile;
        },
        async createData(props) {
            // получение данных с формы(добавление информации)
            let data = await this.prepareRequest(props);
            const headers = {
                'Content-type': 'multipart/form-data'
            };
            axios.post('/api/'+ this.$route.params.section , data, headers).then(()=>{this.showSuccess()}).catch(()=>{this.showFail()});
        },
        showCreateModal() {
            this.$bvModal.show('create');
        },
        showEditModal() {
            this.$bvModal.show('edit');
        },
        showDeleteModal() {
            this.$bvModal.show('delete');
        },
        async updateData(props) {
            console.log(props.file);
            let data = await this.prepareRequest(props);
            console.log(data.get('file'));
            let apiSection = '/api/' + this.$route.params.section + '/' + this.other;
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
           axios.post(apiSection, {
               props : data.get('props'),
               _method : 'patch' // laravel не распознает методы patch и put
           },headers).then(()=>{this.showSuccess()}).catch(()=>{this.showFail()});

           axios.post(apiSection + '/file', data ,headers);  // для загрузки изображений

           this.$bvModal.hide('edit');
          /*  setTimeout(() => {
                this.$router.go();
            },2000);*/
        },
        getLine(event) {
            this.other = event.id;
        },
        async deleteData() {
            axios.delete('/api/' + this.$route.params.section + '/' + this.other ).then(()=>{this.showSuccess()}).catch(()=>{this.showFail()});
            this.$bvModal.hide('delete');
           /* setTimeout(() => {
                this.$router.go();
            },2000); */
        },
        closeDeleteModal() {
            this.$bvModal.hide('delete');
        },
        showSuccess() {
            let toastObject = new Vue();
            toastObject.$bvToast.toast('Запрос успешно отправлен!', {
                title: 'Отправка данных',
                toaster: 'b-toaster-top-right',
                variant: 'success',
            });
        },
        showFail() {
            let toastObject = new Vue();
                toastObject.$bvToast.toast('Не удалось отправить запрос. Проверьте параметры запроса.', {
                    title: 'Отправка данных',
                    toaster: 'b-toaster-top-right',
                    variant: 'danger',
            });
        },
        async getData() {
            let section = this.$route.params.section;
            let response = await axios.get('/api/' + this.$route.params.section);
            return response;
        },
        emitSubmit(event) {
            this.$emit('sendData',{
                form : this.form
            }); // эмиттер для передачи в родительский компонент
        },
        handeAddEvent(event) {
            this.createData({props:event.form, file : event.form.file });
        },
        handleUpdateEvent(event) {
            this.updateData({props : event.form,file:event.form.file});
        }
    }
}
</script>

<style>

</style>
