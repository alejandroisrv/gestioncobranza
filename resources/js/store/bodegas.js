export const STORAGE_KEY = 'PRODUCTOS'
import BodegaService from '../services/bodegas.js';
import moment from 'moment';
import p from '../utils.js';

const state = {
    bodegas: [{}],
    loading: false,
    bodegasFormat:[],
}

const getters = {
    bodegas(state) {
        return state.bodegas
    },
    bodegasFormat(){
      return state.bodegasFormat
    },
    loading (state) {
        return state.loading
    },
}

const mutations = {
    SET_BODEGAS (state, value){
        state.bodegas = value
    },
    SET_BODEGAS_FORMAT(state, value){
        state.bodegasFormat = value
    },
    SET_LOADING_STATUS (state, value) {
        state.loading = value
    },
}

const actions = {

  async initBodega({commit,dispatch}){
      const rs= await BodegaService.getAll();
      dispatch('getBodegasFormat');
      commit('SET_BODEGAS',rs.data.data);
  },
  async getBodegasAll({commit}, query){
      const rs= await BodegaService.getAll(query);
      commit('SET_BODEGAS',rs.data.data);
  },
  async getBodegasFormat({commit,dispatch},query){
    const rs= await BodegaService.getAll(query);
    commit('SET_BODEGAS_FORMAT', p.select2Fortmat(rs.data.data,'bodega'));
  },

}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
