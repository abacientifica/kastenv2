export default {
    namespaced: true,
    state: {
        idmovimiento: 0,
        nro_documento: 0,
        idtercero: 0,
        idtercero2: null,
        nombre: '',
        fecha: null,
        fecha_minima: null,
        fecha_maxima: null,
        fecha3: null,
        condicion_entrega: '2',
        estado: '',
        num_orden: '',
        id_direccion: 0,
        direccion: '',
        prioridad: '1',
        asesor: '',
        forma_pago: '',
        idcontrato: null,
        total_iva: 0,
        sub_total: 0,
        total: 0,
        comentarios: '',
        flete: null,
        idconcepto: null,
        comentarios_internos: '',

        contador: 0
    },
    getters: {
        idtercero: (state) => {
            return state.idtercero
        }
    },

    actions: {
        SET_VARIABLES({ commit }, datos) {
            commit('setVariables', datos);
        },
    },
    mutations: {
        setVariables(state, datos) {
            let variable = Object.keys(datos).toString();
            let valor = Object.values(datos).toString();
            if (variable == 'idtercero') {
                state.idtercero = valor
            } else if (variable == 'id_direccion') {
                state.id_direccion = valor
            } else if (variable == 'idtercero2') {
                state.idtercero2 = valor
            } else if (variable == 'fecha_minima') {
                state.fecha_minima = valor
            } else if (variable == 'fecha_maxima') {
                state.fecha_maxima = valor
            } else if (variable == 'num_orden') {
                state.num_orden = valor
            } else if (variable == 'condicion_entrega') {
                state.condicion_entrega = valor
            } else if (variable == 'prioridad') {
                state.prioridad = valor
            } else if (variable == 'asesor') {
                state.asesor = valor
            } else if (variable == 'idconcepto') {
                state.idconcepto = valor
            } else if (variable == 'comentarios') {
                state.comentarios = valor
            } else if (variable == 'comentarios_internos') {
                state.comentarios_internos = valor
            }
        },
    },
}