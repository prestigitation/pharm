<template>
  <div class="news_block">
      <slot name="img"></slot>
      <slot name="title">

      </slot>
      <slot name="data"></slot>
      <slot name="content">

      </slot>
      <b-button variant='info' class="ml-auto mr-auto d-flex">
          <router-link :to='link'>
              Читать далее
          </router-link>
      </b-button>
  </div>
</template>

<script>
export default {
    props : ['link']
}
</script>

<style>
    .news_block {
        border: 1px solid rgb(67, 139, 221);
        margin: 5px;
        padding:5px;
        text-overflow: ellipsis;
        overflow: hidden;
        display: inline-block;
    }
</style>
