<template>
    <Section>
        <div slot="section_header">
            Добавить поставку
        </div>

        <div slot="section_content">
            <span> Выберите филиал: </span>
            <b-form @submit.prevent="onSubmit">
                <b-form-group>
                    <b-form-select v-model="form.department_select">
                        <option v-for="department in departments" :key="department">
                            {{ department.city + ' ' +  department.address }}
                        </option>
                    </b-form-select>
                </b-form-group>
                <!-- TODO : добавить информацию о поставках(при выборе каждого филиала менять таблицу) -->
            <b-form-group>

                    <span> Добавить поставку </span>
                    <b-form-select v-model="form.product_select">
                        <option v-for="product in products" :key="product">
                            {{ product.name }}
                        </option>
                    </b-form-select>

                    <b-form-input placeholder="Введите количество товара" v-model="form.quantity"> </b-form-input>

                    <span> Выберите поставщика </span>
                    <b-form-select v-model="form.dealer_select">
                        <option v-for="dealer in dealers" :key="dealer">
                            {{ dealer.company }}
                        </option>
                    </b-form-select>

                    <span> Установите статус заказа: </span>
                    <b-form-select v-model="form.status_select">
                        <option v-for="status in statuses" :key="status">
                            {{ status.text }}
                        </option>
                    </b-form-select>
            </b-form-group>

            <b-form-group>
                <div class="text-center">
                    <b-button type="submit" variant="primary">
                        Отправить
                    </b-button>
                </div>
            </b-form-group>

            </b-form>
        </div>
    </Section>
</template>

<script>
export default {
    data() {
       return {
           form : {
               quantity : '',
               product_select : '',
               department_select : '',
               dealer_select : '',
           },
           departments: '',
           products : '',
           dealers : '',
           statuses : '',
        }
    },
    methods : {
        onSubmit() {
            axios.post('products',{ props : JSON.stringify(this.form)});
        }
    },
    props : ['departments','products'],
    async mounted() {
        let info = await axios.post('department_info');
        this.departments = info.data.departments;
        this.products = info.data.products;
        this.dealers = info.data.dealers;
        this.statuses = info.data.statuses;
    },
}
</script>

<style>

</style>
