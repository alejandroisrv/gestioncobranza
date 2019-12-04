export const STORAGE_KEY = 'PRODUCTOS'
import ProductoService from '../services/productos.js';

const state = {
    productos: [{}],
    loading: true,
    productosFormat: [],
}

const getters = {
    productos(state) {
        return state.productos
    },
    productosFormat() {
        return state.productosFormat
    },
    loading(state) {
        return state.loading
    },
}

const mutations = {
    SET_PRODUCTOS(state, value) {
        state.productos = value
    },
    SET_PRODUCTOS_FORMAT(state, value) {
        state.productosFormat = value
    },
    SET_LOADING_STATUS(state, value) {
        state.loading = value
    },
}

const actions = {

    async initProduct({ commit, dispatch }) {
        commit('SET_LOADING_STATUS', true)
        const rs = await ProductoService.getAll();
        dispatch('getProductoFormat');
        commit('SET_PRODUCTOS', rs.data.data);
        commit('SET_LOADING_STATUS', false)
    },
    async getProductosAll({ commit }, query) {
        commit('SET_LOADING_STATUS', true)
        const rs = await ProductoService.getAll(query);
        commit('SET_PRODUCTOS', rs.data.data);
        commit('SET_LOADING_STATUS', false)
    },
    async getProductoFormat({ commit, state }, query) {
        commit('SET_LOADING_STATUS', true);
        const rs = await ProductoService.getAll(query);
        let datos = rs.data.data;
        let productos = [];
        for (let i = 0; i < datos.length; i++) {
            productos.push({
                id: datos[i].id,
                label: `${datos[i].nombre} disponibles ${datos[i].cantidad}`,
                cantidad: parseInt(datos[i].cantidad),
                nombre: datos[i].nombre,
                precioCredito: datos[i].precio_credito,
                precioContado: datos[i].precio_contado,
                precioCredicontado : datos[i].precio_credicontado,
            })
        }
        commit('SET_PRODUCTOS_FORMAT', productos);
        commit('SET_LOADING_STATUS', false);
    },

}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
