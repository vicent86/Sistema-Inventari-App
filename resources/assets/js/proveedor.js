require('./vue-asset');

Vue.component('create-vendor', require('./components/proveedor/CreateVendor.vue'));
Vue.component('view-vendor', require('./components/proveedor/ViewVendor.vue'));

var app = new Vue({
    el:'#inventory'
});
