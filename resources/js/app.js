require('./bootstrap');

window.Vue = require('vue').default;
import MyHeader from './components/MyHeader.vue'
import VueRouter from 'vue-router'
import Vue from 'vue';
import Swal from 'sweetalert2';
import routes from './routes';

/**
 * Define Swal alert 
 */
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)

    }
});
window.Toast = Toast;

/**
 * use vuerouter
 */
Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#app',
    router,
    data() {
        return {
            app_name: process.env.MIX_APP_NAME,
        }
    },
    components: {
        "my-header": MyHeader
    }
});
