require('./bootstrap');
import router from './router'
import Navbar from './components/Navbar'

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router,
    components: {
        Navbar
    }
});
