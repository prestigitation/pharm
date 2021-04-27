<template>

<b-form-group>
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
                :required="isRequired"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-2" label="Категория:" label-for="input-2">
                <b-form-select
                v-model="form.categories"
                :required="isRequired"
                >
                    <option v-for="category in categories" :key='category'>
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
                :required="isRequired"
                >
                    </b-form-input>
            </b-form-group>

            <b-form-group id="input-group-5" label="Описание:" label-for="input-5">
                    <b-form-textarea
                    v-model="form.description"
                    placeholder="Введите описание медикамента"
                    :required="isRequired"
                    >
                    </b-form-textarea>
            </b-form-group>


            <div class="text-center">
                <b-button type="submit" variant="primary" class="m-2" @click.prevent='emitSubmit'>Отправить</b-button>
                <b-button type="reset" variant="danger" class="m-2">Сбросить</b-button>
            </div>
</b-form-group>

</template>

<script>
import UpdateDeleteFunctions from './UpdateDeleteFunctions';
export default {
    extends : UpdateDeleteFunctions,
    data() {
        return  {
            form: {
                file: this.file,
            },
            show: true,
            categories : '',
            isRequired : true, // true для создания , false для апдейта
        }
    },
    props: ['sendData','name','categories','description','contraindications','price'],
    methods: {
      onReset(event) {
        event.preventDefault()
        this.form.contraindications = ''
        this.form.description = ''
        this.form.categories = '';
        this.form.name = ''
        this.price = ''
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      },
    },

    async created() {
        let categoriesPromise = await axios.get('/api/categories');
        this.categories = categoriesPromise.data;
    }
}
</script>

<style>

</style>
