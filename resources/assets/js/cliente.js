require('./vue-asset');
Vue.component('create-customer', require('./components/cliente/CreateCustomer.vue'));
Vue.component('view-customer', require('./components/cliente/ViewCustomer.vue'));

var app = new Vue({

    el: '#inventory'
});
