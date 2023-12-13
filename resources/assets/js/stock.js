require('./vue-asset');
Vue.component('create-stock', require('./components/stock/CreateStock.vue'));
Vue.component('view-stock', require('./components/stock/ViewStock.vue'));

const app = new Vue({
    el: '#app'
});
