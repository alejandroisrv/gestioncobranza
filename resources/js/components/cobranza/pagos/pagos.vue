
<template>
  <div>
    <section class="content-header">
      <h1>Pagos</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
             <div class="box-body" style="line-height:34px;">
              <div class="col-md-1" style="padding-left:20px;">Cliente:</div>
              <div class="col-md-3 p-0"><v-select v-model="parametros.cliente" :options="clientes" placeholder="Selecciona el cliente" /></div>
              <div class="col-md-8 text-right">
                <button class="btn btn-primary" @click="PagoCliente">
                  <i class="fa fa-plus mr-2"></i> Nuevo pago
                </button>
              </div>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de pagos</h3>
              <div class="box-tools">
                <div class="input-group input-group-sm hidden-xs" style="width: 250px;margin:5px;">
                  <input v-model="parametros.venta" @keyup.enter="getPagos()" class="form-control input-buscar" placeholder="Introduce el código de la venta">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default input-buscar"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
              <template v-else>
              <table v-if=" pagos.data && pagos.data.length > 0 " class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Venta</th>
                    <th>Cliente</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in pagos.data" :key="item.id">
                    <th>{{ item.venta.cod }} </th>
                    <td>{{ item.cliente.nombre }}</td>
                    <td>{{ item.monto | currency }}</td>
                    <td>{{ item.fecha | moment('DD/MM/YYYY')  }} </td>
                  </tr>
                </tbody>
              </table>
              <div v-else>
                <p class="py-4">No se han encontrado pagos</p>
              </div>
                <div class="box-footer clearfix">
                  <pagination :data="pagos" @pagination-change-page="getPagos"></pagination>
                </div>
              </template>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>

      <pago-cliente />

    </section>
  </div>
</template>
<script>

import PagoCliente from '../acuerdos/ModalPago';
import AcuerdoService from '../../../services/acuerdos_pagos'
import ClienteService from '../../../services/clientes';

export default {
  data() {
    return {
      pagos:[],
      loading:false,
      clientes:[],
      parametros:{
          cliente:'',
          venta:''
      }
    };
  },
  components: { PagoCliente },
  created() {
    this.getPagos();
    this.eventHub.$on('getPagos', () => {
        this.getPagos();
    });
    this.getClientes();
  },
  methods: {
    async getPagos(page = 1){
      this.loading = true;
      const rs = await AcuerdoService.getPagos({ venta:this.parametros.venta ,cliente: this.parametros.cliente != '' ?  this.parametros.cliente.id : '', page});
      console.log(rs);
      this.pagos = rs.data.body;
      this.loading = false;
    },
    async getClientes(){
        const rs = await ClienteService.getAll();
        rs.data.body.data.forEach(element => {
            this.clientes.push({id:element.id,label:element.nombre});
        });
    },
    PagoCliente() {
     this.eventHub.$emit('PagoCliente');
    },
  },
  watch: {
      "parametros.cliente"() {
          this.getPagos();
      },
  },
};
</script>
