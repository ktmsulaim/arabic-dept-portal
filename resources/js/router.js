import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from './components/Login/Login'
import Home from './components/Pages/Home'
import Users from './components/Pages/users/Index'
import AddUser from './components/Pages/users/AddUser'


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
            name: 'Users',
            component: Users
        },
        {
            path: '/users/add',
            name: 'NewUser',
            component: AddUser
        }
    ]
})