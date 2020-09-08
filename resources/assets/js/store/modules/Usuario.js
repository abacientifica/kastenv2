export default {
    namespaced: true,
    state: {
        usuario: ''
    },
    actions: {
        async SET_USUARIO({ commit }) {
            const res = await axios.get('/usuario/datosusr')
            commit('setUsuario', res.data.user)
        }
    },

    getters: {
        obtUsuario: (state) => {
            return state.usuario;
        }
    },

    mutations: {
        setUsuario(state, user) {
            state.usuario = user
        },
    },
}