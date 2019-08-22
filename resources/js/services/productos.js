import p from '../utils'
import api from './api.js'

export default {
    getAll(params = null) {
        let query = p.converParamters(params);
        return api().get('productos' + query);
    },
    editarProducto(id) {
        return api().get('producto/update/' + id);
    },
    abastecerProductos(params) {
        return api().post('/producto/abastecer', params);
    },
    get(id) {
        return api().get('producto' + p.converParamters(params));
    },
    edit(id, params) {
        return api().post(`/producto/update/${id}`, params);
    },
    deleteProducto(id) {
        return api().get('/producto/delete/' + id);
    },
    entregarProductos(params) {
        if (params == null || params == '' || params.length < 2) return false
        return api().post('/producto/entregar', params);
    }
}