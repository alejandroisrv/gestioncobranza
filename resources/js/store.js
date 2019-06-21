import Vue from 'vue';
import Vuex from 'vuex';
import users from './store/users.js';
import productos from './store/productos.js';
import bodegas from './store/bodegas.js';


Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        items: []
    },
    modules: {

        users,bodegas,productos

    },
    mutations: {
        INIT_STORE (state) {
          console.log("Store running...");
        }
    },
    actions: {

    },
    strict: false,

})

export default store
