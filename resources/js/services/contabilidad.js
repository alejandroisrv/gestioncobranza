import p from '../utils'
import api from './api.js'

export default {
    getAll(params) {
        console.log(p.converParamters(params))
        return api().get('/contabilidad/all' + p.converParamters(params));
    },
    getCategory(params) {
        return api().get('/contabilidad/categorias' + p.converParamters(params));
    },
    addCategory(params) {
        return api().post('/contabilidad/categoria', params);
    },
    updateCategory(params) {
        return api().post('contabilidad/categoria/edit', params);
    },
    deleteCategory(id) {
        return api().post('/contabilidad/categoria/delete/' + id);
    },

}