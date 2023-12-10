import Vue from 'vue'
import Router from 'vue-router'
import HomeComponent from './resources/assets/js/components/login/login.vue'
import Register from './resources/assets/js/components/register/register.vue'

Vue.use(Router)

export default new Router ({
    routes: [
        {
            path: '/login',
            name: 'login',
            component: HomeComponent
        },
        {
            path: '/registrar',
            name: 'register',
            component: Register
        },
    ]
})
