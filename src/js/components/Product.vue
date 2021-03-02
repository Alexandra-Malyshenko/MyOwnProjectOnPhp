<template>
  <div class="col-lg-4 col-md-4 col-sm-12 pb-5">
    <div class="card h-100">
      <img :src="`${ image }`" class="card-img-top" alt="..." @click="fullImage">
      <div class="card-body text-center">
        <h5 class="">{{ title }}</h5>
        <p>Цена : <b>{{ price }} грн. / кг</b> </p>
        <p class=""><i>{{ description }}</i></p>
      </div>
      <div class="card-footer text-center">
        <a class="add-to-cart" :href="`/cart/add/${id}`" style="text-decoration: none">
          <button class="btn btn-success">Заказать</button>
        </a>
        <a :href="`/product/view/${id}`" style="text-decoration: none">
          <button class="btn btn-info">Подробнее</button>
        </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Product",
  props: {
    id: {
      type: Number,
      require: true
    },
    title: {
      type: String,
      require: true
    },
    price: {
      type: Number,
      require: true
    },
    description: {
      type: String,
      require: true
    },
    image: {
      type: String,
      require: true
    }
  },
  methods: {
    fullImage() {
      this.$emit('fullSize', this.image)
    }
  }
}
</script>

<style scoped>
img:hover {
  background-color: black;
  opacity: 0.8;
}

</style>