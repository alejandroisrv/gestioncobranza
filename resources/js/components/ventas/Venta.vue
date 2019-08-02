<template>
  <div>
      <bootstrap-modal  ref="ventaDetalle" :need-header="true" :need-footer="true" :size="'medium'">
      <div slot="title">Detalle de venta</div>
      <div slot="body" >
        <div class="box-body">
          <template v-if="venta!==''">
            <div class="row">
              <div class="col-md-12">
                <p style="font-size:18px;" class="mb-1"> Venta {{ venta.tipos_ventas.descripcion }} </p>
                <p class="col-md-6 px-0 mb-1 text-muted">  Vendedor: {{ venta.vendedor.name }}  </p>
                <p class="col-md-6 px-0 mb-1 text-muted">  Cliente: {{ venta.persona.nombre }} {{ venta.persona.apellido }} </p>
                <p class="col-md-6 px-0 mb-1 text-muted fecha-text"> Fecha: {{ venta.created_at | moment('DD/MM/YYYY H:m:s') }} </p>
                <template v-if="venta.tipo_venta == 2">
                  <p class="col-md-4 px-0 mb-1 text-muted">  Periodo de pago: <span style="font-weight:600;">{{ venta.acuerdo_pago.periodo_pago}} </span> </p>
                  <p class="col-md-4 px-0 mb-1 text-muted">  Número de cuotas: <span style="font-weight:600;">{{ venta.acuerdo_pago.cuotas  }} </span>  </p>
                  <p class="col-md-4 px-0 text-muted">  Monto de las cuotas: {{ montoCuotas | currency }} </p>
                  <p class="col-md-4 px-0 mb-1 text-muted"> Abono: <span style="font-weight:600;">{{ venta.abono | currency  }} </span>  </p>                  
                  <p class="col-md-4 px-0 mb-1 text-muted"> Descuento: <span style="font-weight:600;">{{ venta.Descuento | currency  }} </span>  </p>                  
                </template>  
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <p style="font-size:16px;" class="mb-1">Productos vendidos</p>
                <table class="table table-condensed">
                  <tr v-for='item in venta.productos_venta' :key="item.id+'a'"> 
                    <td>{{ item.producto }} <b>x{{ item.cantidad }}</b> </td>  
                  </tr>
                  <tr>
                    <th style="font-size:16px"> Sub-total: {{ venta.subtotal | currency }}</th>
                  </tr>
                  <tr>
                    <th style="font-size:16px"> Total: {{ venta.total | currency }}</th>
                  </tr>
                </table>
              </div>
            </div>
          </template>
        </div>
      
      </div>
      <div slot="footer">
        <button type="submit" class="btn btn-primary" @click="closeTheModalVenta">Continuar</button>
      </div>
    </bootstrap-modal>
  </div>
</template>
<script>
import $ from "jquery";
import { log } from "util";
import { totalmem } from "os";
export default {
    data(){
      return {
        venta:''
      }
    },
    components: {
    "bootstrap-modal": require("vue2-bootstrap-modal")
  },
  created() {
    this.eventHub.$on("openDetalle", (venta) => {
      this.venta = venta;
      this.openTheModalVenta();

    });
  },
  computed:{
    montoCuotas(){
      let cuota;
      if(this.venta!=''){
        cuota=this.venta.total/this.venta.acuerdo_pago.cuotas;
      }
      return cuota;
    }
  },
  methods: {
    openTheModalVenta() {
      this.$refs.ventaDetalle.open();
    },
    closeTheModalVenta() {
      this.$refs.ventaDetalle.close();
    },
  }
};
</script>

<style scoped>
.form-group {
  padding: 10px !important;
}
</style>

