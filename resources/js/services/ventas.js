import p from '../utils'
import api from './api.js'

export default {
    newVenta(venta){
        if(venta==null || venta==undefined) return false;
        return api().post('ventas',venta);
    },
    getAll(params=null) {
        let query =  p.converParamters(params) ;
        return api().get('ventas'+query);
    },
    get(params) {
        return api().get('venta'+ p.converParamters(params));
    },
    update(id,params){
      return api().post(`/venta/update/${id}`,params);
    },
    getTipos(params=null){
        let query =  p.converParamters(params) ;
        return api().get("/ventas/tipos"+query);
    }
}
