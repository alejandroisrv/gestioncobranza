import Vue from 'vue';
import Vuex from 'vuex';
import users from './store/users.js';
import productos from './store/productos.js';
import bodegas from './store/bodegas.js';
import municipios from './store/municipios.js'
import clientes from './store/clientes';
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        items: []
    },
    modules: {
        users, bodegas, productos,municipios,clientes
    },
    mutations: {
        INIT_STORE(state,value) {
        }
    },
    actions: {
        initStore({dispatch, state}){
            dispatch('municipios/initMunicipios');
            console.log("Store running...");
        }
    },
    strict: false,

})

export default store
