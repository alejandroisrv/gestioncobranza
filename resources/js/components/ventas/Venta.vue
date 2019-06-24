<template>
  <div>
      <bootstrap-modal  ref="ventaDetalle" :need-header="true" :need-footer="true" :size="'medium'">
      <div slot="title">Detalle de venta</div>
      <div slot="body" >
        <div class="box-body">
          <template v-if="venta!==''">
        <div class="row">
          <div class="col-md-6"> Fecha: {{ venta.created_at }}</div>
          <div class="col-md-6"> <b>{{venta.tipo_venta.descripcion }} </b></div>
        </div>
        <div class="row">
          <div class="col-md-6"> Vendedor:{{ venta.vendedor.name }} </div>
          <div class="col-md-6"> Cliente: {{ venta.persona.nombre }} {{ venta.persona.sojo }} </div>

        </div>
        <div class="row">
          <div class="col-md-13"> <p>Acuerdo de pago</p></div>
          <div class="col-md-4"> Periodo de pago {{ venta.acuerdo_pago.periodo_pago}}</div>
          <div class="col-md-4"> Cuotas {{ venta.acuerdo_pago.cuotas  }}</div>
          <div class="col-md-4"> Monto de las cuotas {{ montoCuotas }}</div>
        </div>
        <div class="row">
          <div class="col-12">
            <p> Productos </p>
          </div>
          <div class="col-12">
            <table>
              <tr v-for='item in venta.productos_ventas' :key="item.id+'a'"> 
                <td>{{ item.producto }}</td>  
                <td>{{ item.cantidad }}</td>  
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
      console.log(this.venta);
      
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

