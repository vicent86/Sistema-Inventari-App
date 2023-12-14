require('./vue-asset');

Vue.component('create-vendor', require('./components/proveedor/CreateVendor.vue').default);
Vue.component('view-vendor', require('./components/proveedor/ViewVendor.vue').default);

const app = new Vue({
    el: '#app'
});
