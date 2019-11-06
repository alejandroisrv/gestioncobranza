
<template>
  <bootstrap-modal ref="detalleCliente" :need-header="true" :need-footer="true" :size="'medium'">
    <div slot="title">Cliente</div>
    <div slot="body"> 
      <div class="box-body" v-if="cliente!=''">
        <div class="row">
          <div class="col-md-12">
            <h4 style="margin-top:0px;" class="title-detalle">{{ cliente.nombre}} C.I {{ cliente.cedula }} <i style="font-size:11px; margin-left:10px;" class="text-muted">Cliente desde hace {{ cliente.created_at | moment("from", "now", true)}}</i></h4>
          </div>
        </div>
        <div class="row mt-1">
          <div class="col-md-12 col-lg-12">
            <p class="mb-1 descripcion-detalle">{{ cliente.direccion}} - {{ cliente.municipio.municipio }} <small> {{ cliente.adicional }} </small>. </p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-6"><p class="mb-1">Teléfono: {{ cliente.telefono }}</p></div>
          <div class="col-md-6 col-lg-6"><p class="mb-1">E-mail: {{ cliente.email}}</p></div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-6">
            <p class="mb-1" v-if="cliente.ruta == 0">No tiene ninguna ruta asignada.</p>
            <p class="mb-1" v-else>Pertenece a la ruta de {{ cliente.ruta_items.ruta.nombre }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-6">
            <p class="mb-1" v-if="calcularDeuda(cliente.ventas) > 0 "><b>Deuda actual: {{ calcularDeuda(cliente.ventas) | currency }}</b></p>
            <p class="mb-1" v-else>No posee deuda actualmente.</p>
          </div>
        </div>
        <div class="row" v-if="calcularDeuda(cliente.ventas) > 0">
          <div class="col-md-12 col-lg-12 mt-2">
            <p class="mb-1"  v-if="cliente.pagos_clientes_count == 0 ">No ha realizado ningún abono.</p>
            <template v-else>
              <p class="col-md-12 mb-1 px-0" style="font-size:16px;"><b> Abonos </b></p>
              <template v-for="venta in cliente.ventas" v-if="venta.abonos.length > 0">
                <small style="font-size: 14px;margin-bottom:10px;"> Venta #{{ venta.cod }}</small>
                <table class="table table-bordered my-2">
                  <thead>
                      <tr><th>Monto</th> <th> Saldo </th> <th>Fecha </th> </tr>
                  </thead>
                  <tbody>
                    <tr v-for="abono in venta.abonos">
                      <td>{{ abono.monto | currency  }}</td> 
                      <td>{{ abono.saldo | currency  }}</td> 
                      <td>{{ abono.fecha | moment('DD/MM/YYYY ')  }} </td> 
                    </tr>
                  </tbody>
                </table>
              </template>
            </template>
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
    calcularDeuda(ventas){
      let deuda = 0;
      let pagos = 0;
        ventas.forEach(venta => {
          deuda += parseFloat(venta.total);
          venta.abonos.forEach(abono => {
              pagos +=  parseFloat(abono.monto);
          });
        });
      return deuda - pagos;
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
