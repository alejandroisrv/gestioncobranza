import p from '../utils'
import api from './api.js'

export default {
    getAll(params=null) {
        let query =  p.converParamters(params) ;
        return api().get('cobros'+query);
    },
    add(params){
        return api().post('/cobros/add',params);
    },

}
