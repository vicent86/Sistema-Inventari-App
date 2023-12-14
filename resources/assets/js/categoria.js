require('./vue-asset');
Vue.component('create-category', require('./components/categoria/CreateCategory.vue').default);
Vue.component('view-category', require('./components/categoria/ViewCategory.vue').default);

const app = new Vue({
    el: '#app'
});
