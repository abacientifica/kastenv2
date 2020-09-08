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
Vue.component('historicomov', require('./components/PedidosHistorico.vue'));
Vue.component('facturacion', require('./components/Facturacion.vue'));
Vue.component('solicitud-devolucion', require('./components/SolicitudesDevolucion.vue'));
Vue.component('filtromov', require('./components/FiltroMov.vue'));
Vue.component('notificacion', require('./components/Notification.vue'));
Vue.component('reporte-ventas', require('./components/ReporteVentas.vue'));
Vue.component('loader', require('./components/Loader.vue'));
Vue.component('commits', require('./components/CambiosSistema.vue'));
Vue.component('nuevomovimiento', require('./components/movimientos/NuevoMovimiento.vue'));
Vue.component('pruebas', require('./components/movimientos/PruevaVuex.vue'));
Vue.component('configuracionesdoc', require('./components/configuraciones/ConfiguracionesDocumentos.vue'));
//Con mixin creamos variables globales que se puede utilizar en todos los componentes

import Echo from 'laravel-echo'
import VueLocalStorage from 'vue-localstorage'
Vue.use(VueLocalStorage)
import Vuex, { mapActions, mapGetters } from 'vuex'
import store from './store'

const app = new Vue({

    el: '#app',
    store,
    //Inicializamos la variable menu en 0 para los demas elementos del menu
    data: {
        menu: 0,
        menus: 0,
        notifications: [],
        Usuario: '',
        Nombres: '',
        Email: '',
        Tipo: '',
        IdTercero: '',
        //Variables de  session
        events: ['click', 'mousemove', 'mousedown', 'scroll', 'keypress', 'load'],
        warningTimer: null, //Muestra el mensaje de alerta de cierre de session
        logoutTimer: null, //El tiempo que va esperar si no confirma el cierre de session 
        warningZone: false // se puede utilizar para mostrar un mensaje de alerta.
    },

    created() {

        let me = this;
        axios.post('notification/get').then(function(response) {
            me.notifications = response.data;
        }).catch(function(error) {
            console.log(error);
        });

        //La variable userId obtiene el valor de la etiqueta meta que contiene el usuario logueado
        var userId = localStorage.Usuario //$('meta[name="userId"]').attr('content');
        window.Echo.private('App.User.' + userId).notification((notification) => {
            me.notifications.push(notification);
        });
    },

    computed: {
        //Almacena en el local storage los objetos del usuario logueado
        ...mapGetters(['obtUsuario']),
        user() {
            localStorage.Usuario = this.obtUsuario["Usuario"];
            localStorage.Nombres = this.obtUsuario["Nombres"];
            localStorage.Email = this.obtUsuario["Email"];
            localStorage.Tipo = this.obtUsuario["Tipo"];
            localStorage.IdTercero = this.obtUsuario["IdTercero"];
            return this.obtUsuario;
        },


    },

    destroyed() {
        this.events.forEach(function(event) {
            window.removeEventListener(event, this.resetTimer);
        }, this);

        this.resetTimer();
    },

    methods: {

        //Inicio metodos para cierre de sesion automatico 

        setTimers: function() {
            //Iniciamos el contador
            this.warningTimer = setTimeout(this.warningMessage, 14 * 60 * 1000); // 14 minutos  60 * 1000
            this.warningZone = false;
        },

        warningMessage: function() {
            let me = this;
            this.warningZone = true;
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Alerta',
                text: "Hemos detectado inactividad, deseas cerrar la sesion ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'SI',
                cancelButtonText: 'NO',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    me.logoutUser();
                    swalWithBootstrapButtons.fire(
                        '',
                        'sesion cerrada con exito.',
                        'success'
                    )
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.resetTimer();
                }
            })
            this.logoutTimer = setTimeout(this.logoutUser, 40 * 1000); //14 minutos 14 * 60* 1000
        },

        logoutUser: function() {
            document.getElementById('logout-form').submit();
        },

        resetTimer: function() {
            clearTimeout(this.warningTimer);
            clearTimeout(this.logoutTimer);
            this.setTimers();
        },

        ...mapActions('Usuario', ['SET_USUARIO']),

    },

    mounted() {

        //Capturamos cada evento para reiniciar el contador
        this.events.forEach(function(event) {
            window.addEventListener(event, this.resetTimer);
        }, this);

        this.SET_USUARIO();
    }
});