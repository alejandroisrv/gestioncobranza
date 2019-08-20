
import Vue from "vue"
import moment from 'moment';


Vue.filter('dateFormat', (fecha, formato) => {
    return moment(fecha).format(formato)
});

Vue.filter('cobrosEstado',(estado)=>{
    if(estado==0){
        return 'Sin comenzar'
    }else if(estado==1){
        return 'En curso'
    }else if (estado==2){
        return 'Finalizado'
    }
});
