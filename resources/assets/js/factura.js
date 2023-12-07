require('./vue-asset');
Vue.component('create-invoice', require('./components/factura/CreateInvoice.vue'));
Vue.component('view-invoice', require('./components/factura/ViewInvoice.vue'));

var app = new Vue({

    el: '#inventory'
});
