<template>
  <div class="comment">
      <span class="lead ">
            <slot name="comment_author"></slot>

      </span>
      <div class="comment_content">
          <slot name="comment_content"></slot>
      </div>
  </div>
</template>

<script>
export default {

}
</script>

<style>
    .comment_content {
        font-size : 22px;
    }
</style>
