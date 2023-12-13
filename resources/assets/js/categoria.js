require('./vue-asset');
Vue.component('create-category', require('./components/categoria/CreateCategory.vue'));
Vue.component('view-category', require('./components/categoria/ViewCategory.vue'));

const app = new Vue({
    el: '#app'
});
