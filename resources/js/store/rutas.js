
export const STORAGE_KEY = 'USUARIOS'
import moment from 'moment';
import p from '../utils.js';

const state = {
    rutas: [{}],
    loading: false,
    rutasFormat:[],
}

const getters = {
    rutas (state) {
        return state.rutas
    },
    rutasFormat(){
      return state.rutasFormat
    },
    loading (state) {
        return state.loading
    },
}

const mutations = {
    SET_USER (state, value){
        state.rutas = value
    },
    SET_USER_FORMAT(state, value){
        state.rutasFormat = value
    },
    SET_LOADING_STATUS (state, value) {
        state.loading = value
    },
}

const actions = {

  async initRutas({commit,dispatch}){
      const rs= await RutaService.getAll();
      dispatch('getRutasFormat');
      commit('SET_USER',rs.data.body);
  },
  async getRutasAll({commit}, query){
      const rs= await RutaService.getAll(query);
      commit('SET_USER',rs.data.body);
  },
  async getRutasFormat({commit,dispatch},query){
    const rs= await RutaService.getAll(query);
    commit('SET_USER_FORMAT', p.select2Fortmat(rs.data.body.data));
  },

}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}