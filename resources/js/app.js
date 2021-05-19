
require('./bootstrap');

window.Vue = require('vue').default;
import Myheader from './components/MyHeader.vue'
import VueRouter from 'vue-router'
import Vue from 'vue';
import Swal from 'sweetalert2';
import routes from './routes';
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

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history', routes
})

const app = new Vue({
    el: '#app',
    router,
    components: {
        Myheader
    }
});
