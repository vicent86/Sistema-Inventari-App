import Vue from 'vue';
import VueRouter from 'vue-router'
import Login from './resources/assets/js/components/login/login.vue'
import Register from './resources/assets/js/components/register/register.vue'

Vue.use(VueRo)

const routes = [
    { path: '/login', component: Login },
    { path: '/registro', component: Register }
]

const router = new VueRouter({
    routes
})

const app = new Vue({
    router
}).$mount('#app')
