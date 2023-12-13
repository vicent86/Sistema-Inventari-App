require('./vue-asset');
Vue.component('create-invoice', require('./components/factura/CreateInvoice.vue'));
Vue.component('view-invoice', require('./components/factura/ViewInvoice.vue'));

const app = new Vue({

    el: '#app'
});
