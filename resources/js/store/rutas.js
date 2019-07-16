
export const STORAGE_KEY = 'USUARIOS'
import moment from 'moment';
import p from '../utils.js';
import RutaService from '../services/rutas';
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
    SET_RUTA (state, value){
        state.rutas = value
    },
    SET_RUTA_FORMAT(state, value){
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
      commit('SET_RUTA',rs.data.body);
  },
  async getRutasAll({commit}, query){
      const rs= await RutaService.getAll(query);
      commit('SET_RUTA',rs.data.body);
  },
  async getRutasFormat({commit,dispatch},query){
    const rs= await RutaService.getAll(query);
    let format=[];
    let datos = rs.data.body.data;
    for(let i=0;i < datos.length; i++){
        format.push({id:datos[i].id,label:datos[i].nombre, items:datos[i].items})
    }
    commit('SET_RUTA_FORMAT',format);
  },

}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
