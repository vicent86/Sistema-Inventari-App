require('./vue-asset');
Vue.component('create-product', require('./components/producto/CreateProduct.vue').default);
Vue.component('view-product', require('./components/producto/ViewProduct.vue').default);


const app = new Vue({

    el: '#app'
});
