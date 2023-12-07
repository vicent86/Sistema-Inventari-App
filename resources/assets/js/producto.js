require('./vue-asset');
Vue.component('create-product', require('./components/producto/CreateProduct.vue'));
Vue.component('view-product', require('./components/producto/ViewProduct.vue'));


var app = new Vue({

    el: '#inventory'
});
