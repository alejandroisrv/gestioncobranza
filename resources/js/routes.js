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
import Unauthorized from './errors/Unauthorized'
import Cartera from './components/cobranza/cartera/cartera';
import Acuerdos from './components/cobranza/acuerdos/acuerdos_pagos'
import Contabilidad from './components/contabilidad/contabilidad';
import Historial from './components/Inventario/historial';
import Municipios from './components/sucursales/Municipios';


Vue.use(VueRouter)
const user =  JSON.parse(localStorage.getItem('auth'));

const isAdmin = (to,from,next) =>{
  if(user && user.role == 1){
    next();
  }else {
    next({name:'401'})
  }
}

const isAdminBodega = (to,from,next) =>{
  if(user && (user.role == 2 || user.role == 1)){
    next();
  }else {
    next({name:'401'})
  }
}

const isCobrador = (to,from,next) =>{
  if(user && (user.role == 3 || user.role == 1 )){
    next();
  }else {
    next({name:'401'})
  }
}

const isVendedor = (to,from,next) =>{
  if(user && user.role == 4 || user.role == 1){
    next();
  }else {
    next({name:'401'})
  }
}

const isAuth = (to,from,next) => {
  if(user){
    next();
  }else{
    next({name:'401'})
  }
}

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
          path: '/',
          name: 'Dashboard',
          component: Dashboard,
          beforeEnter: isAuth
        },
        {
          path: '/inventario',
          name: 'Inventario',
          component: Inventario,
          beforeEnter: isAdminBodega
        },
        {
            path: '/clientes',
            name: 'clientes',
            component: Clientes
        },
        {
            path: '/bodegas',
            name: 'bodegas',
            component: Bodegas,
            beforeEnter:isAdminBodega
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
            path: '/municipios',
            name: 'municipios',
            component: Municipios
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
        { path: '*', name:'404', component: NotFoundComponent },
        { path: '/401', name:'401',component: Unauthorized }

    ]
})


export default router;
