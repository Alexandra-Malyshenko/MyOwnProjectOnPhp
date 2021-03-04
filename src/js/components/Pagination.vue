<template>
  <ul class='pagination'>
    <li v-if="currentPage !== 1" class='page-item'>
      <button class='page-link' @click="changePage(1)">
        <span aria-hidden='true'>&laquo;</span>
      </button>
    </li>
    <li v-for="page in totalPages" :key="page"
        class='page-item'
        @click="changePage(page)"
        :class="{active: currentPage === page}">
        <button class='page-link'>{{ page }}</button>
    </li>
    <li v-if="currentPage !== totalPages" class='page-item'>
      <button class='page-link' @click="changePage(totalPages)">
        <span aria-hidden='true'>&raquo;</span>
      </button>
    </li>
  </ul>
</template>

<script>
export default {
  name: "Pagination",
  props: {
    total: {
      type: Number,
      require: true
    },
    itemsOnPage: {
      type: Number,
      require: true
    }
  },
  data() {
    return {
      currentPage: 1
    }
  },
  computed: {
    totalPages() {
      return Math.ceil(this.total / this.itemsOnPage)
    }
  },
  methods: {
    changePage(pageNumber) {
      this.currentPage = pageNumber
      this.$emit('page-changed', pageNumber)
    }
  }
}
</script>

<style scoped>

</style>