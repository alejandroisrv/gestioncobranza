export const STORAGE_KEY = 'VENTAS'
import VentaService from '../services/ventas';


const state = {
    ventas: {data:[{}]},
    ventasFormat:[{}],
    loading: true,
    tiposVenta:[{}]
}

const getters = {
    loading (state) {
        return state.loading
    },
    ventas (state) {
        return state.ventas
    },
    ventasFormat(){
      return state.ventasFormat
    },
    tiposVenta(){
        return state.tiposVenta;
    },
  
}

const mutations = {
    SET_LOADING_STATUS (state, value) {
        state.loading = value
    },
    SET_VENTAS (state, value){
        state.ventas = value
    },
    SET_VENTAS_FORMAT(state, value){
        state.ventasFormat = value
    },
    SET_TIPOS_VENTAS(state, value ){
        state.tiposVenta = value
    }

}

const actions = {
  async initVentas({commit,dispatch}){
      commit('SET_LOADING_STATUS',true)
      const rs = await VentaService.getAll();
      dispatch('getVentasFormat');
      dispatch('getTipos');
      commit('SET_VENTAS',rs.data.body);
      commit('SET_LOADING_STATUS',false)
  },
  async getVentasAll({commit}, query){
      commit('SET_LOADING_STATUS',true)
      const rs = await VentaService.getAll(query);
      commit('SET_VENTAS',rs.data.body);
      commit('SET_LOADING_STATUS',false)
  },
  async getVentasFormat({commit,state},query){
    commit('SET_LOADING_STATUS',true);
    const rs = await VentaService.getAll(query);
    let datos = rs.data.body.data;
    let ventas=[];
    for (let i = 0; i < datos.length; i++) {
      ventas.push({id:datos[i].id,
        label:`${datos[i].nombre} ${datos[i].apellido}`
      })
    }
    commit('SET_VENTAS_FORMAT',ventas);
    commit('SET_LOADING_STATUS',false);
  },
  async getTipos({commit}, query=null){
    const rs = await VentaService.getTipos(query);
    let datos = rs.data;
    let ventas=[];
    for (let i = 0; i < datos.length; i++) {
      ventas.push({id:datos[i].id,label:datos[i].descripcion})
    }
    commit('SET_TIPOS_VENTAS', ventas);
  }

  

}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
