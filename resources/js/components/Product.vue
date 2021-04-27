<template>
  <div class="card_template">
      <div class="card_img">
          <slot name="img"></slot>
      </div>
      <div class="card_data">
          <slot name="data"></slot>
      </div>
      <div class="card_price">
          <slot name="price"></slot>
      </div>
  </div>
</template>

<script>
export default {
}
</script>

<style>
    .card_template {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-content: center;
        margin-top: 20px;
        margin: 20px;
        width: 250px;
        height: 350px;
        border: 1px solid black;
    }

    .card_price {
        font-size: 18px;
    }

    .card_data {
        text-align: center;
        font-family: 'Montserrat', sans-serif;
    }
</style>
