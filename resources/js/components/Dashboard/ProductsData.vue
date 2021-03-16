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
        </div>
        <b-modal id="edit">
            <div slot="modal-footer"></div>
            <Section>
            <div slot="section_header">
                    <span> Редактировать информацию о товаре  </span>
            </div>

                <div slot="section_content">

                <b-form @submit.prevent="update" id="myform">

                    <b-form-file class=""
                    v-model="form.file"
                    placeholder="Загрузите изображение товара..."
                    drop-placeholder="Drop file here..."
                    accept=".jpg, .png"
                    required></b-form-file>

                    <b-form-group id="input-group-1" label-for="input-1" class="mt-4">
                        <b-form-input
                        v-model="form.name"
                        placeholder="Введите название медикамента"
                        required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-2" label="Категория:" label-for="input-2">
                        <b-form-select
                        v-model="form.categories"
                        required
                        >
                            <option v-for="category in categories.data" :key='category'>
                                {{ category.name }}
                            </option>
                        </b-form-select>
                    </b-form-group>

                    <b-form-group id="input-group-3" label="Противопоказания:" label-for="input-3">
                            <b-form-textarea
                            id="textarea1"
                            v-model="form.contraindications"
                            placeholder="Введите противопоказания (если есть)"
                            >
                            </b-form-textarea>
                    </b-form-group>

                    <b-form-group id="input-group-4" label="Цена:" label-for="input-4">
                        <b-form-input
                        v-model="form.price"
                        placeholder="Введите цену продажи (за 1ед. товара)"
                        required
                        >
                            </b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-5" label="Описание:" label-for="input-5">
                            <b-form-textarea
                            v-model="form.description"
                            placeholder="Введите описание медикамента"
                            required
                            >
                            </b-form-textarea>
                    </b-form-group>


                    <div class="text-center">
                        <b-button type="submit" variant="primary" class="m-2">Отправить</b-button>
                    </div>

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
    </Section>
</template>

<script>
import Section from './Section';
import UpdateDeleteFunctions from './UpdateDeleteFunctions';
export default {
    extends: UpdateDeleteFunctions,
    data() {
        return {
            form: {
                file: this.file,
            },
            categories : '',
            products:'',
            fields : [
                { key : 'name', label : 'Изображение'},
                { key : 'category', label : 'Город' },
                { key : 'description', label : 'Точный адрес'},
                { key : 'contraindications', label : 'ID ответственного'},
                { key : 'price', label : 'Создан' },
                { key : 'actions', label : 'Действия' }
            ],
        }
    },
    props : ['products','categories','description','contraindications'],
    async created() {
        let response = await axios.post('products');
        this.products = response.data.products;
        this.categories = await axios.post('categories');
    }
}
</script>

<style>

</style>
