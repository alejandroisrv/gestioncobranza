import Vue from 'vue';
import Vuex from 'vuex';
import users from './store/users.js';
import productos from './store/productos.js';
import bodegas from './store/bodegas.js';
import municipios from './store/municipios.js'
import clientes from './store/clientes';
import ventas from './store/ventas'
import cobros from './store/cobros';
import rutas from './store/rutas';
import contabilidad from './store/contabilidad'
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        items: [],
        perfilActual: JSON.parse(localStorage.getItem('auth'))
    },
    modules: {
        users,
        bodegas,
        productos,
        municipios,
        clientes,
        ventas,
        cobros,
        rutas,
        contabilidad
    },
    mutations: {
        INIT_STORE(state, value) {}
    },
    actions: {
        initStore({ dispatch, state }) {
            dispatch('municipios/initMunicipios');
            console.log("Store running...");
        }
    },
    strict: false,

})

export default store