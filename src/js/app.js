window.Vue = require('vue')

Vue.component('product', require('./components/Product.vue').default)
Vue.component('products', require('./components/Products.vue').default)
Vue.component('pagination', require('./components/Pagination.vue').default)
Vue.component('sorting', require('./components/Sorting.vue').default)

const app = new Vue({
    el: '#app',
})