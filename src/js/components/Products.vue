<template>
  <div class="row pb-5 container-product">
    <div class="col-lg-12 d-flex justify-content-end pb-3 mb-3">
      <div class="dropdown">
        <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownSort' aria-haspopup='true' data-bs-toggle='dropdown' aria-expanded='false'>
          Сортировать
        </button>
        <sorting @sort-changed="changeSort"></sorting>
      </div>
    </div>
    <product v-for="(product, index) in products" :key="index"
             :id = "product.id" :title = "product.title"
             :price = "product.price" :description = "product.description"
             :image = "product.image" @fullSize="showImage"
    ></product>
    <div v-if="isImage" class="image-container" id="fullImage" @click="close">
      <img class="img" :src="`${ isImage }`" >
    </div>
    <div class="col-lg-12 d-flex justify-content-center">
      <nav aria-label="Page navigation">
        <pagination :total="total" :itemsOnPage="6" @page-changed="changePage"></pagination>
      </nav>
    </div>
  </div>
</template>

<script>
export default {
  name: "Products",
  data() {
    return {
      products: [],
      isImage: '',
      pageNumber: 1,
      total: 0,
      sort: 'title-ASC'
    }
  },
  methods: {
    async getData() {
      try {
        const result = await fetch(`http://lovelybakery.loc/category/getProductsAPI?page=${this.pageNumber}&sort=${this.sort}`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json'
          }
        });
        let data =  await result.json();
        this.products = data[0];
        this.total = data['count'];

      } catch(error) {
        console.log(error);
      }
    },
    showImage(img) {
      this.isImage = img;
    },
    close() {
      this.isImage = '';
    },
    changeSort(sortBy) {
      this.sort = sortBy
    },
    changePage(page) {
      this.pageNumber = page
    }
  },
  watch: {
    sort() {
      this.getData()
    },
    pageNumber() {
      this.getData()
    }
  },
  created() {
    this.getData();
  }
}
</script>

<style scoped lang="scss">
.container-product {
  position: relative;
}
.image-container {
  position: absolute;
  top: 50%;
  left: 50%;
  margin-right: -50%;
  transform: translate(-50%, -50%);
  width: 75%;
  height: 75%;
}
.img {
  width: 100%
}
</style>