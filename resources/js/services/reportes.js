import p from '../utils'
import api from './api.js'

export default {
    get(params = null) {
        let query = p.converParamters(params);
        return api().get('/reportes/all' + query);
    },
}