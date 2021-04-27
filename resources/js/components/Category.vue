<template>
  <div>
      <div class="category_card">
          <slot name="card"></slot>
          <span class="category_text">
            <slot name="text"></slot>
        </span>
      </div>
  </div>
</template>

<script>
export default {

}
</script>

<style>
    .category_card {
        padding: 20px;
        margin: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 150px;
        height: 35px;
        border : 1px solid black;
        background: #4CA1AF;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #C4E0E5, #62bcca);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #C4E0E5, #62bcca); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        -webkit-text-stroke: 0.7px rgb(34, 60, 148);
    }

    .category_text:hover {
        border-bottom: 2px solid white;
        cursor: pointer;
    }
</style>
