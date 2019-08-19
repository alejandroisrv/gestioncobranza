import p from '../utils'
import api from './api.js'

export default {
    getAll(params=null) {
        let query =  p.converParamters(params) ;
        return api().get('comisiones'+query);
    },
    pay(id){
      return api().get(`/comisiones/pagar/${id}`);
    },

}
