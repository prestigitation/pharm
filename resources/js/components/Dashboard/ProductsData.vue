<template>
    <Section>
        <div slot="section_header">
            Все товары
        </div>
        <div slot="section_content">
            <b-table :items="products" :fields="fields" table-variant="info" class="text-center" @row-hovered="getLine">
                <template #cell(actions)>
                    <b-icon-pencil-square role="button" variant="success" title="Редактировать" @click="showEditModal"></b-icon-pencil-square>
                    <b-icon-x role="button" variant="danger" title="Удалить" @click="showDeleteModal"></b-icon-x>
                </template>
            </b-table>

            <b-card role="button" class="text-center lead w-50 mr-auto ml-auto" bg-variant="primary" @click="showCreateModal"> Добавить <b-icon-plus-circle> </b-icon-plus-circle> </b-card>
            <b-form-input v-model="newCategory" placeholder="Вы можете добавить категорию" class="w-50 m-3 ml-auto mr-auto">  </b-form-input>
            <b-button type="submit" role="button" class="ml-auto mr-auto d-flex" @click.prevent="addCategory" variant="success"> Отправить </b-button>

            <div>
                <span> Вы можете добавить скидку на товар :  </span>
                <products-search v-model="selectedProd" ref="discountProduct"></products-search>
                <b-form-input v-model="discountPrice" placeholder="Введите сумму со скидкой"></b-form-input>
                <b-button variant="primary" @click.prevent="appendDiscount" class="w-25 ml-auto mr-auto d-flex justify-content-center">Добавить</b-button>
            </div>
        </div>
        <b-modal id="edit">
            <div slot="modal-footer"></div>
            <Section>
            <div slot="section_header">
                    <span> Редактировать информацию о товаре  </span>
            </div>

                <div slot="section_content">

                <b-form id="myform">
                    <products-form @sendData="handleUpdateEvent"></products-form>
                </b-form>
            </div>
    </Section>
     </b-modal>

        <b-modal id="delete">
            <div slot="modal-footer"></div>
            <div class="text-center">
                <span> Вы действительно хотите удалить товар из списка? </span>
                <div class="m-2">
                    <b-button type="submit" @click.prevent="deleteData" variant="success">  Да </b-button>
                    <b-button type="submit" @click.prevent="closeDeleteModal" variant="danger"> Отмена </b-button>
                </div>
            </div>
        </b-modal>

        <b-modal id="create">
            <div slot="modal-footer"></div>
            <products-form @sendData="handeAddEvent"></products-form>
        </b-modal>
    </Section>
</template>

<script>
import ProductsForm from './ProductsForm.vue';
import ProductsSearch from './ProductsSearch.vue';
import Section from './Section';
import UpdateDeleteFunctions from './UpdateDeleteFunctions';
export default {
  components: { ProductsSearch },
    components : ProductsForm   ,
    extends: UpdateDeleteFunctions,
    data() {
        return {
            newCategory:'',
            products:'',
            fields : [
                { key : 'name', label : 'Название'},
                { key : 'category', label : 'Группа' },
                { key : 'description', label : 'Описание'},
                { key : 'contraindications', label : 'Противопоказания'},
                { key : 'price', label : 'Цена' },
                { key : 'actions', label : 'Действия' }
            ],
            other : '',
            selectedProd : '',
            discountPrice:'',
        }
    },
    props : ['form','sendData'],
    async created() {
        let productPromise = await this.getData();
        this.products = productPromise.data;
        let categoriesPromise = await axios.get('/api/categories');
        this.categories = categoriesPromise.data;
    },
    methods : {
        addCategory() {
           axios.post('/api/categories',{data : this.newCategory})
        },
        async appendDiscount() {
            await axios.post('/api/products/' + this.$refs.discountProduct.$data.productId + '/discount',{
                discountPrice : this.discountPrice
            })
        }
    }
}
</script>

<style>

</style>
