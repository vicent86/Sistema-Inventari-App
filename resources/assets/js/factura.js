require('./vue-asset');
Vue.component('create-invoice', require('./components/factura/CreateInvoice.vue').default);
Vue.component('view-invoice', require('./components/factura/ViewInvoice.vue').default);

const app = new Vue({

    el: '#app'
});
