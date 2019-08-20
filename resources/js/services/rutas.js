import p from '../utils'
import api from './api.js'

export default {
    getAll(params=null) {
      console.log(params);
        let query =  p.converParamters(params) ;
        return api().get('rutas'+query);
    },
    add(params){
      return api().post('/rutas/add',params);
    },
    edit(params){
      return api().post(`/rutas/update`,params);
    },
    delete(id){
        return api().get('/rutas/delete/'+ id);
    },
    suspend(id){
        return api().get('/rutas/suspend?id='+id);
    }

}
