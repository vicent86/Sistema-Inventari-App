require('./vue-asset');
Vue.component('create-user', require('./components/user/CreateUser.vue'));
Vue.component('view-user', require('./components/user/ViewUser.vue'));

const app = new Vue({
    el: '#app'
});
