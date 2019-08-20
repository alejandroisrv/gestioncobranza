
<template>
  <bootstrap-modal ref="detalleCliente" :need-header="true" :need-footer="true" :size="'large'">
    <div slot="title">Cliente</div>
    <div slot="body"> 
      <div class="box-body" v-if="cliente!=''">
        <div class="row">
          <div class="col-md-12">
            <h4>Datos del Cliente</h4>
          </div>
        </div>
        <div class="row">
        <div class="col-md-4 col-lg-4">
          <p class="text-muted mb-1">{{ cliente.nombre}} {{cliente.apellido}}</p>
        </div>
        <div class="col-md-4 col-lg-4"><p class="text-muted mb-1">C.I {{ cliente.cedula }}</p></div>
         <div class="col-md-4 col-lg-4"><p class="text-muted mb-1">Teléfono: {{ cliente.telefono }}</p></div>
      </div>
      <div class="row">
        <div class="col-md-4 col-lg-4">
          <p class="text-muted mb-1">Dirección: {{ cliente.direccion}}</p>
        </div>
        <div class="col-md-4 col-lg-4">
          <p class="text-muted mb-1">E-mail: {{ cliente.email}}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 col-lg-4">
          <p class="text-muted mb-1">Deuda actual :{{ calcularDeuda(cliente.acuerdos_pagos) | currency }}</p>
        </div>
        <div class="col-md-4 col-lg-4 fecha-text"><i>Cliente desde hace {{ cliente.created_at | moment("from", "now", true)}}</i></div>
      </div>
      <div class="row">
        <div class="col-md-12 col-lg-12" v-if="ventas.data && ventas.data.length > 0">
          <h4>Últimas compras</h4>
          <table class="table table-condensed ">
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
            <tbody>
              <tr v-for="item in ventas.data" :key="item.id">
                <td>{{ item.vendedor.name }}</td>
                <td>{{ item.tipos_ventas.descripcion }}</td>
                <td>{{ item.acuerdo_pago.periodo_pago}}</td>
                <td>{{ item.total }}</td>
                <td>{{ item.created_at }}</td>
                <td>
                  <button class="btn btn-default">V</button>
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
  data() {
    return {
      cliente:'',
      ventas: [{}],
      loading: true
    };
  },
  created() {
    //ABRIR
    this.eventHub.$on("verCliente", (cliente) => { 
      console.log(cliente);
      this.cliente=cliente;
      this.open(); 
    });
  },
  components: {
    "bootstrap-modal": require("vue2-bootstrap-modal")
  },
  computed: {},
  methods: {
    async getVenta(id) {
      let query = { cliente: id };
      const rs = await VentaService.getAll(query);
      this.ventas = rs.data.body;
      this.loading = false;
      
    },
    calcularDeuda(acuerdo){
      let deuda = 0;
      acuerdo.forEach(e => {
        
        if((e.cuotas > e.cuotas_pagadas ) && (e.estado == 0)){
          deuda += parseInt((e.cuotas-e.cuotas_pagadas) * (e.monto/e.cuotas));
        }

        
      });
      return deuda;
    },
    open() {
      this.$refs.detalleCliente.open();
    },
    close() {
      this.$refs.detalleCliente.close();
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
