
export const STORAGE_KEY = 'USUARIOS'
import CobroService from '../services/cobros';

const state = {
    cobros: [{
        data:{}
    }],
    loading: false,
}

const getters = {
    cobros (state) {
        return state.cobros
    },
    cobrosFormat(){
      return state.cobrosFormat
    },
    loading (state) {
        return state.loading
    },
}

const mutations = {
    SET_COBROS (state, value){
        state.cobros = value
    },
    SET_LOADING_STATUS (state, value) {
        state.loading = value
    },
}

const actions = {

  async getCobrosAll({commit}, query){
      commit('SET_LOADING_STATUS',true);
      const rs= await CobroService.getAll(query);
      commit('SET_COBROS',rs.data.body);
      commit('SET_LOADING_STATUS',false);
  },
 


}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
