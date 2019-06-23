import p from '../utils'
import api from './api.js'

export default {
    getAll(params=null) {
        let query =  p.converParamters(params) ;
        return api().get('clientes'+query);
    },
    add(params){
      return api().post('/cliente/add',params);
    },
    edit(id,params){
      return api().post(`/cliente/update/${id}`,params);
    },
    delete(id){
        return api().get('/cliente/delete/'+ id);
    },
    suspend(id){
        return api().get('/clientes/suspend?id='+id);
    }

}
