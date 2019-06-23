
<template>
  <bootstrap-modal ref="clienteModal" :need-header="false" :need-footer="true" :size="'large'">
    <div slot="title">Cliente</div>
    <div slot="body"> 
      <div v-if="cliente">
           <div class="row">
        <div class="col-4">
          <p>{{ cliente.nombre}} {{cliente.apellido}}</p>
        </div>
        <div class="col-4">{{ cliente.cedula }}</div>
      </div>
      <div class="row">
        <div class="col-12">
          <p>Dirección:{{ cliente.direccion}}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <p>Email:{{ cliente.email}}</p>
        </div>
        <div class="col-4">Telf:{{ cliente.telefono }}</div>
      </div>
      <div class="row">
        <div class="col-4">
          <p>Deuda actual :{{ cliente.acuerdos_pagos.monto}}</p>
        </div>
        <div class="col-4">Próximo pago: {{ cliente.proximo_pago }}</div>
        <div class="col-4">Cliente desde {{ cliente.fecha }}</div>
        <div class="col-4">{{ cliente.fecha }}</div>
      </div>
      <div class="row">
        <div class="col-12">
          <p>Últimas compras</p>
          <table>
            <thead>
              <tr>
                <th>Vendedor</th>
                <th>Tipo de venta</th>
                <th>Perido de pago</th>
                <th>Total</th>
                <th>Fecha</th>
                <th></th>
              </tr>
            </thead>
            <tbody v-if="ventas && ventas.length > 0">
              <tr v-for="item in ventas" :key="item.id">
                <td>{{ item.vendedor.name }}</td>
                <td>{{ item.tipos_ventas.descripcion }}</td>
                <td>{{ item.acuerdo_pago.periodo_pago}}</td>
                <td>{{ item.total }}</td>
                <td>{{ item.created_at }}</td>
                <td>
                  <button class="btn btn-default">Detalle</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      </div>
    </div>
    <div slot="footer">
      <button type="button" class="btn btn-primary" @click="close">Continuar</button>
    </div>
  </bootstrap-modal>
</template>


<script>
import { mapGetters, mapActions } from "vuex";
import VentaService from "../../services/ventas";
export default {
  props: ["cliente"],
  data() {
    return {
      ventas: [{}],
      loading: true
    };
  },
  created() {
    //ABRIR
    this.eventHub.$on("detalleCliente", () => {  this.open(); });
  },
  components: {
    "bootstrap-modal": require("vue2-bootstrap-modal")
  },
  computed: {},
  methods: {
    async getVenta(id) {
      let query = { cliente: id };
      const rs = await VentaService.getAll(query);
      this.ventas = rs.data;
      this.loading = false;
    },
    open() {
      this.$refs.clienteModal.open();
    },
    close() {
      this.$refs.clienteModal.close();
    }
  },
  watch:{
    cliente(){
      if(this.cliente.id != undefined){
        this.getVenta(this.cliente.id);
      }
    }
  }
};
</script>
