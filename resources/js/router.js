import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from './components/Login/Login'
import Home from './components/Pages/Home'


Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            redirect: 'Home'
        },
        {
            path: '/login',
            component: Login,
            name: 'LoginView'
        },
        {
            path: '/home',
            component: Home,
            name: 'Home'
        },
        {
            path: '/users',
            name: 'Users'
        },
        {
            path: '/users/add',
            name: 'NewUser'
        }
    ]
})