require('./bootstrap');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('create-vendor', require('./components/proveedor/CreateVendor.vue').default);
Vue.component('update-vendor', require('./components/proveedor/UpdateVendor.vue').default);
Vue.component('view-vendor', require('./components/proveedor/ViewVendor.vue').default);

const app = new Vue({
    el: '#app',
});
