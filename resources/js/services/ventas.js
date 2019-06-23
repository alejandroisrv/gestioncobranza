import p from '../utils'
import api from './api.js'

export default {
    getAll(params=null) {
        let query =  p.converParamters(params) ;
        return api().get('ventas'+query);
    },
    get(params) {
        return api().get('venta'+ p.converParamters(params));
    },
    update(id,params){
      return api().post(`/venta/update/${id}`,params);
    }
}
