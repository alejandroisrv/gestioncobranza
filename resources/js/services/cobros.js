import p from '../utils'
import api from './api.js'

export default {
    getAll(params=null) {
        return api().get('/cobros'+ p.converParamters(params));
    },
    add(params){
        return api().post('/cobros/add',params);
    },

}
