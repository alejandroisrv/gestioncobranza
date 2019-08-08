import p from '../utils.js'
import api from './api.js'

export default {
    getAll(params = null) {
        let query = p.converParamters(params);
        return api().get('nomina/all' + query);
    },
    getData() {


    },
    add(params) {

        return api().post('nomina/add', params);
    },
    edit(params) {
        let query = p.converParamters(params);
        return api().post('nomina/edit', query);
    },
    delete(id) {
        return api().post('nomina/delete/' + id);
    },
    roles() {
        return api().get('nomina/roles/all');
    }

}