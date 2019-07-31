
<template>
  <div>
    <section class="content-header">
      <h1>Acuerdos de</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-right">
              <button class="btn btn-primary" @click="PagoCliente()">
                <i class="fa fa-plus mr-2"></i> Registrar nuevo pago
              </button>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Ca</h3>
            </div>
            <div class="box-body">
              <table v-if=" acuerdo_pagos.data && acuerdo_pagos.data.length > 0 " class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Cliente</th>
                    <th>Periodo de pago</th>
                    <th>Monto</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in acuerdo_pagos.data" :key="item.id">
                    <td>{{ item.cliente.nombre }} {{ item.cliente.apellido  }}  </td>
                    <td>{{ item.periodo_pago  }}</td>
                    <td>{{ item.monto | currency }}</td>
                    <td>{{ item.estado  }} </td>
                    <td> {{ item.created_at | moment('DD/MM/YYYY')  }} </td>
                    <td>
                      <button class="btn btn-default btn-sm" @click="verDetalle(item)">
                        <i class="fa fa-eye"></i>
                      </button>
                      <button class="btn btn-danger btn-sm" @click="eliminarCliente(item.id)">
                        <i class="fa fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div v-else>
                <p class="py-4">No se han encontrado acuerdos de pagos</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- <modal-acuerdo :acuerdo="acuerdo"></modal-acuerdo> -->

      <acuerdo/>
    </section>
  </div>
</template>
<script>
import modalAcuerdoPago from "../acuerdos/modalAcuerdo";
import Acuerdo from "../acuerdos/acuerdo";
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
    modalAcuerdoPago,Acuerdo
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

