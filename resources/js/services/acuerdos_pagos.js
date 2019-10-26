import p from '../utils.js'
import api from './api.js'

export default {

    getAll(params = null) {
        console.log(params);

        let query = p.converParamters(params);
        return api().get('/acuerdos_pagos' + query);
    },

    add(params) {
        if (params == null) return false;
        return api().post('/acuerds_pagos', params);
    },

    nuevoPago(params) {
        if (params == null) return false;
        return api().post('/acuerdos_pagos/nuevo-pago', params);
    },
    getPagos(params) {
        let query = p.converParamters(params);
        return api().get('/pagos' + query);
    },
    get(id) {
        if (id == null) return false;
        return api().get('/acuerdo_pago/' + id);
    }

}