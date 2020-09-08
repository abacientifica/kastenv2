import Vue from "vue"
import Vuex from 'vuex'
import NuevoMovimiento from './modules/NuevoMovimiento'
import Usuario from './modules/Usuario'
Vue.use(Vuex);
export default new Vuex.Store({

    modules: {
        NuevoMovimiento,
        Usuario
    },

    state: {
        prueba: ''
    },
})