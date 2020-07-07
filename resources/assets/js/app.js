/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('pedidos', require('./components/Pedidos.vue'));
Vue.component('usuarios', require('./components/Usuarios.vue'));
Vue.component('configuracion', require('./components/ConfiguracionUsr.vue'));
const app = new Vue({
    el: '#app',
    //Inicializamos la variable menu en 0 para los demas elementos del menu
    data: {
        menu: 0
    }
});