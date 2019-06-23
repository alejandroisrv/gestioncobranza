export const STORAGE_KEY = 'CLIENTES'
import ClienteService from '../services/clientes';


const state = {
    clientes: {data:[{}]},
    loading: true,
    clientesFormat:[{}],
}

const getters = {
    clientes (state) {
        return state.clientes
    },
    clientesFormat(){
      return state.clientesFormat
    },
    loading (state) {
        return state.loading
    },
}

const mutations = {
    SET_CLIENTES (state, value){
        state.clientes = value
    },
    SET_CLIENTES_FORMAT(state, value){
        state.clientesFormat = value
    },
    SET_LOADING_STATUS (state, value) {
        state.loading = value
    },

}

const actions = {
  async initClientes({commit,dispatch}){
      commit('SET_LOADING_STATUS',true)
      const rs= await ClienteService.getAll();
      dispatch('getClientesFormat');
      commit('SET_CLIENTES',rs.data.body);
      console.log(rs);
      
      commit('SET_LOADING_STATUS',false)
  },
  async getClientesAll({commit}, query){
      commit('SET_LOADING_STATUS',true)
      const rs= await ClienteService.getAll(query);
      commit('SET_CLIENTES',rs.data.body);
      commit('SET_LOADING_STATUS',false)
  },
  async getClientesFormat({commit,state},query){
    commit('SET_LOADING_STATUS',true);
    const rs= await ClienteService.getAll(query);
    let datos = rs.data.body.data;
    let clientes=[];
    for (let i = 0; i < datos.length; i++) {
      clientes.push({id:datos[i].id,
        label:`${datos[i].nombre} ${datos[i].apellido}`
      })
    }
    commit('SET_CLIENTES_FORMAT',clientes);
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
