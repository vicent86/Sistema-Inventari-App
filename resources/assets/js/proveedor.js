require('./vue-asset');

Vue.component('create-vendor', require('./components/proveedor/CreateVendor.vue'));
Vue.component('view-vendor', require('./components/proveedor/ViewVendor.vue'));

const app = new Vue({
    el: '#app'
});
