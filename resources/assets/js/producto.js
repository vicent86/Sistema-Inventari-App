require('./vue-asset');
Vue.component('create-product', require('./components/producto/CreateProduct.vue'));
Vue.component('view-product', require('./components/producto/ViewProduct.vue'));


const app = new Vue({

    el: '#app'
});
