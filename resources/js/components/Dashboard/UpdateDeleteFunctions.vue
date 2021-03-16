<template>

</template>

<script>
export default {
    methods: {
        prepareRequest(props) {
            let formFile = new FormData();
            formFile.append('props', props.props);
            formFile.append('file', props.file);
            formFile.append('other', props.other);
            return formFile;
            },
        async createData(props) {
            console.log(props)
            // получение данных с формы(добавление информации)
            let data = await this.prepareRequest(props);
            console.log(data);
            const headers = {
                'Content-type': 'multipart/form-data'
            };
            Vue.axios.post(window.location.href, data, headers).then(()=>{this.showSuccess()}).catch(()=>{this.showFail()});
        },
        showEditModal() {
            this.$bvModal.show('edit');
        },
        showDeleteModal() {
            this.$bvModal.show('delete');
        },
        async update(props,updatingId) {
            console.log(updatingId);
            let data = await this.prepareRequest(props);
            axios.post('update', { props: JSON.stringify(props), updatingId: updatingId }).then(()=>{this.showSuccess()}).catch(()=>{this.showFail()});
            this.$bvModal.hide('edit');
          /*  setTimeout(() => {
                this.$router.go();
            },2000);*/
        },
        getLine(event) {
            this.other = event.id;
        },
        deleteData() {
            axios.post('delete', { props: { deletingId: this.other } }).then(()=>{this.showSuccess()}).catch(()=>{this.showFail()});
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
    }
}
</script>

<style>

</style>
