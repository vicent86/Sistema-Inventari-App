require('./vue-asset');
Vue.component('create-stock', require('./components/stock/CreateStock.vue').default);
Vue.component('view-stock', require('./components/stock/ViewStock.vue').default);

const app = new Vue({
    el: '#app'
});
