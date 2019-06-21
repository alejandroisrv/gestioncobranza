import p from '../utils.js'
import api from './api.js'

export default {
    getAll(params=null) {
        let query =  p.converParamters(params) ;
        return api().get('/bodegas'+query);
    },

}
