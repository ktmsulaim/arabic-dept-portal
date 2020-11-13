require('./bootstrap');
import router from './router'
import Navbar from './components/Navbar'
import { ValidationProvider, ValidationObserver } from 'vee-validate';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';


window.Vue = require('vue');

/**
 * Vue Toast
 */
Vue.use(VueToast, {
    position: 'bottom-right'
});


/**
 * Validation Provider
 */
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

const app = new Vue({
    el: '#app',
    router,
    components: {
        Navbar,
    }
});
