export const STORAGE_KEY = 'CONTABILIDAD'

const state = {
    categorias: [{}],
}

const getters = {
    categorias(state) {
        return state.categorias
    },

}

const mutations = {
    SET_CATEGORIAS(state, value) {
        state.categorias = value
    },
}

const actions = {

}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}