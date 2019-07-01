import p from '../utils.js'
import api from './api.js'

export default {
    
    getAll(params=null) {
        let query =  p.converParamters(params) ;
        return api().get('/acuerdos_pagos'+query);
    },

    add(params){
        if(params==null) return false;
        return api().post('/acuerds_pagos',params);
    },

    get(id){
        if(id==null) return false;
        return api().get('/acuerdo_pago/'+id);
    }

}
