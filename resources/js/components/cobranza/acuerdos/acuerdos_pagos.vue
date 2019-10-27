
<template>
  <div>
    <section class="content-header">
      <h1>Acuerdos de pago</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-right">
              <!-- <button class="btn btn-primary" @click="PagoCliente()">
                <i class="fa fa-plus mr-2"></i> Nuevo pago
              </button> -->
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de Acuerdos de pago</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
              <template v-else>
              <table v-if=" acuerdo_pagos.data && acuerdo_pagos.data.length > 0 " class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Venta</th>
                    <th>Cliente</th>
                    <th>Cuotas</th>
                    <th>Periodo de pago</th>
                    <th>Monto</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in acuerdo_pagos.data" :key="item.id">
                    <th>{{ item.venta.cod }} </th>
                    <td>{{ item.cliente.nombre }}</td>
                    <td>{{ item.cuotas }}</td>
                    <td>{{ item.periodo_pago  }}</td>
                    <td>{{ item.monto | currency }}</td>
                    <td>{{ item.estado  }} </td>
                    <td>{{ item.created_at | moment('DD/MM/YYYY')  }} </td>
                    <td>
                      <button class="btn btn-default btn-sm" @click="verDetalle(item)">
                        <i class="fa fa-eye"></i>
                      </button>
                      <!-- <button class="btn btn-danger btn-sm" @click="eliminarCliente(item.id)">
                        <i class="fa fa-trash"></i>
                      </button> -->
                    </td>
                  </tr>
                </tbody>
              </table>
              <div v-else>
                <p class="py-4">No se han encontrado acuerdos de pagos</p>
              </div>
              </template>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <!-- <modal-acuerdo :acuerdo="acuerdo"></modal-acuerdo> -->

      <acuerdo/>
      <pago-cliente />
    </section>
  </div>
</template>
<script>
import PagoCliente from './ModalPago';
import Acuerdo from "./acuerdo";
import AcuerdoService from '../../../services/acuerdos_pagos'
import { log } from "util";
export default {
  data() {
    return {
      loading:false,
      acuerdo_pagos:{}
    };
  },
  components: {
    Acuerdo,PagoCliente
  },
  created() {
    this.getAcuerdos();
    this.eventHub.$on("sendCliente", rs => {
      this.getClientes();
    });
  },
  methods: {

    async getAcuerdos(){
      this.loading = true;
      const rs = await AcuerdoService.getAll();
      this.acuerdo_pagos = rs.data.body;
      this.loading = false;
    },
    PagoCliente() {
     this.eventHub.$emit('PagoCliente');
    },
    verDetalle(item) {
      this.eventHub.$emit('verAcuerdo',item);
    },
  }
};
</script>
