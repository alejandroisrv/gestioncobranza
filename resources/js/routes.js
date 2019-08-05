import VueRouter from 'vue-router';
import Vue from 'vue'

import Dashboard from './components/dashboard/dashboard.vue'
import Clientes from './components/clientes/Clientes.vue'
import Inventario from './components/Inventario/Inventario.vue'
import Bodegas from './components/bodegas/Bodegas';
import Ventas from './components/ventas/Ventas'
import Sucursales from './components/sucursales/Sucursales'
import Morosos from './components/cobranza/morosos';
import Nomina from './components/nomina/nomina';
import Comisiones from './components/nomina/comisiones'
import Rutas from './components/rutas/rutas';
import Cobros from './components/cobranza/cobros/cobros';
import NotFoundComponent from './errors/NotFoundComponent'
import Cartera from './components/cobranza/cartera/cartera';
import Acuerdos from './components/cobranza/acuerdos/acuerdos_pagos'
import Contabilidad from './components/contabilidad/contabilidad';
import Historial from './components/Inventario/historial';

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    routes: [{
            path: '/',
            name: 'Dashboard',
            component: Dashboard
        },
        {
            path: '/inventario',
            name: 'Inventario',
            component: Inventario
        },
        {
            path: '/clientes',
            name: 'clientes',
            component: Clientes
        },
        {
            path: '/bodegas',
            name: 'bodegas',
            component: Bodegas
        },
        {
            path: '/ventas',
            name: 'ventas',
            component: Ventas
        },
        {
            path: '/sucursales',
            name: 'sucursales',
            component: Sucursales
        },
        {
            path: '/morosos',
            name: 'Morosos',
            component: Morosos
        },
        {
            path: '/nomina',
            name: 'Nomina',
            component: Nomina
        },
        {
            path: '/comisiones',
            name: 'Comisiones',
            component: Comisiones
        },
        {
            path: '/rutas',
            name: 'Rutas',
            component: Rutas

        },
        {
            path: '/cobros',
            name: 'Cobros',
            component: Cobros
        },
        {
            path: '/cartera/:ruta',
            name: 'Cartera',
            component: Cartera
        },
        {
            path: '/acuerdos',
            name: 'Acuerdos',
            component: Acuerdos
        },
        {
            path: '/contabilidad',
            name: 'Contabilidad',
            component: Contabilidad

        },
        {
            path: '/historial',
            name: 'Historial',
            component: Historial

        },
        { path: '*', component: NotFoundComponent }

    ]
})