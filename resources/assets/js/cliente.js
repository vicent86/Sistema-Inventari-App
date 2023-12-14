require('./vue-asset');
Vue.component('create-customer', require('./components/cliente/CreateCustomer.vue').default);
Vue.component('view-customer', require('./components/cliente/ViewCustomer.vue').default);

const app = new Vue({

    el: '#app'
});
