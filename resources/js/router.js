import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from './components/Login/Login'
import Home from './components/Pages/Home'
import Users from './components/Pages/users/Index'
import AddUser from './components/Pages/users/AddUser'
import Batches from './components/Pages/batches/Index'
import Students from './components/Pages/students/Index'
import CreateStudent from './components/Pages/students/Create'
import ViewStudent from './components/Pages/students/View'
import EditStudent from './components/Pages/students/Edit'
import Search from './components/Pages/students/Search'


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
        },
        {
            path: '/batches',
            name: 'Batches',
            component: Batches
        },
        {
            path: '/students',
            name: 'Students',
            component: Students
        },
        {
            path: '/students/add',
            name: 'CreateStudent',
            component: CreateStudent
        },
        {
            path: '/students/edit/:id',
            name: 'EditStudent',
            component: EditStudent
        },
        {
            path: '/students/view/:id',
            name: 'ViewStudent',
            component: ViewStudent
        },
        {
            path: '/search',
            name: 'Search',
            component: Search,
            props: route => ({query: route.query.q})
        }
        
    ]
})