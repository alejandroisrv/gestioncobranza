export const STORAGE_KEY = 'MUNICIPIOS'
import MunicipioService from '../services/municipios';

const state = {
    municipios: [{}],
    municipiosFormat: [{}]
}

const getters = {
    municipios(state) {
        return state.municipios
    },
    municipiosFormat(state) {
        return state.municipiosFormat;
    }
}

const mutations = {
    SET_MUNICIPIOS(state, value) {
        state.municipios = value
    },
    SET_MUNICIPIOS_FORMAT(state, value) {
        state.municipiosFormat = value;
    }
}

const actions = {
    async initMunicipios({ commit, dispatch }) {
        
        const rs = await MunicipioService.getAll();
        commit('SET_MUNICIPIOS', rs.data.body);
        dispatch('municipiosFormat');
  
    },
    async getMunicipiosAll({ commit }, query) {

        const rs = await MunicipioService.getAll(query);
        commit('SET_MUNICIPIOS', rs.data.body);
    },
    async municipiosFormat({ commit }, query) {
        const rs = await MunicipioService.getAll(query);
        let datos = rs.data.body;
        let municipios = [{id:'all',label:'Todos'}];
        for (let i = 0; i < datos.length; i++) {
            municipios.push({ id: datos[i].id, label: datos[i].municipio })
        }
        commit('SET_MUNICIPIOS_FORMAT', municipios);
    },

}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
