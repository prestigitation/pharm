<template>
  <div>
    <Section>
      <div slot="section_header">
            <span> Добавить медикамент  </span>
      </div>

        <div slot="section_content">

            <b-form @submit.prevent="create({props:JSON.stringify(form)})" @reset="onReset" v-if="show" id="myform">

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
                <b-button type="reset" variant="danger" class="m-2">Сбросить</b-button>
            </div>

        </b-form>
    </div>
    </Section>
  </div>

</template>

<script>
import Section from './Section';
import UpdateDeleteFunctions from './UpdateDeleteFunctions';
  export default {
    extends : UpdateDeleteFunctions,
    data() {
      return {
        form: {
          file: this.file,
        },
        show: true,
        categoriesList : '',
      }
    },
    props: ['categories','description','contraindications'],
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
        this.categories = await axios.post('categories');
    }
  }
</script>
