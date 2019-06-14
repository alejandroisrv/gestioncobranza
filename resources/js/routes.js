import VueRouter from 'vue-router';
import Vue from 'vue'

import Dashboard from './components/dashboard/dashboard.vue'
import Clientes from './components/clientes/Clientes.vue'
import Inventario from './components/Inventario/Inventario.vue'
import Bodegas from './components/bodegas/Bodegas';
import Ventas from './components/ventas/Ventas'
import Sucursales from './components/sucursales/Sucursales'

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    routes: [
        {
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
            path: '/login',
            name: 'sucursales',
            component: Sucursales
        }


    ]
})
