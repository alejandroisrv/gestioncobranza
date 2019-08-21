<template>
  <div>
    <bootstrap-modal ref="VentaNueva" :need-header="true" :need-footer="true" :size="'large'">
      <div slot="title">Nueva Venta</div>
      <div slot="body">
        <form @submit.prevent="generateVenta" id="ventaFrom">
          <div class="box-body">
            <p> Vendedor: <small>{{ $store.state.perfilActual.name}}</small></p>
            <div class="row">
              <div class="form-group col-md-6">
                <label>Cliente</label>
                <v-select v-model="VentaGeneral.cliente" :options="clientes" placeholder="Seleciona un cliente"></v-select>
              </div>
              <div class="form-group col-md-6">
                <label>Tipo de venta</label>
                <v-select v-model="VentaGeneral.tipo" :options="tiposVenta" placeholder="Seleciona un tipo de venta"></v-select>
              </div>
            </div>
            <div class="row">
              <template v-if="VentaGeneral.tipo && VentaGeneral.tipo.id   == 2 ">
                <div class="form-group col-md-4">
                  <label>Periodo de pago</label>
                  <v-select v-model="VentaGeneral.periodo" :options="['Semanal','Quincenal','Mensual']" placeholder="Seleciona el periodo de pago"></v-select>
                </div>
              <div class="form-group col-md-3">
                <label>Monto de las cuotas</label>
                <input type="text" name="monto" class="form-control" v-model="VentaGeneral.monto" placeholder="Introduce el monto de las cuotas">
              </div>
              <div class="form-group col-md-3">
                <label>Abono</label>
                <input type="text" name="cuotas" class="form-control" v-model="VentaGeneral.abono" placeholder="Introduce el monto a abonar">
              </div>
              </template>
              <div class="form-group col-md-2">
                <label>Descuento</label>
                <input type="text" name="monto" class="form-control" v-model="VentaGeneral.descuento" placeholder="Descuento">
              </div>
              <div class="col-md-12 mt-3">
                <label>Productos</label>
                <div class="my-3">
                  <div class="row my-3">
                    <div class="col-md-6">
                      <v-select v-model="item.producto" :options="productList" placeholder="Seleciona un producto"></v-select>
                    </div>
                    <div class="col-md-5">
                      <input  v-model.number="item.cantidad" placeholder="Cantidad" class="form-control" @keyup.enter="addCuadro()">
                    </div>
                    <div class="col-md-1 text-right">
                      <button class="btn btn-primary" type="button" @click.prevent="addCuadro()">
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                  </div>
                  <table class="table table-condensed " v-if="VentaGeneral.productosVendidos.length > 0">
                    <thead>
                      <tr>
                        <th>Producto</th><th>Cantidad</th><th>Sub-total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(productoVendido,idx) in VentaGeneral.productosVendidos" :key="idx+'prod'">
                        <td>{{ productoVendido.producto.nombre }}</td>
                        <td>{{ productoVendido.cantidad }}</td>
                        <td>{{ productoVendido.subtotal | currency }}</td>
                        <td>
                          <i class="fa fa-times text-danger" @click="deleteProductoVendido(idx)"></i>
                        </td>
                      </tr>
                      <tr>
                        <th style="font-size:16px;">Sub-total: <span>{{ subtotal | currency }} </span></th>
                      </tr>
                      <tr>
                        <th style="font-size:17px;">Total: <span>{{ total | currency }} </span></th>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div slot="footer">
        <button type="button" class="btn btn-default" @click="closeTheModal">Cancelar</button>
        <button type="button" class="btn btn-primary" @click="generateVenta">Guardar</button>
      </div>
    </bootstrap-modal>
  </div>
</template>
<script>
import axios from "axios";
import {mapGetters,mapActions } from 'vuex';
export default {
  components: {
    "bootstrap-modal": require("vue2-bootstrap-modal")
  },
  data() {
    return {
      url: "/api/ventas",
      item: { producto: "", cantidad: "", subtotal: 0 },
      VentaGeneral: {
        cliente: null,
        periodo:null,
        tipo:null,
        abono: '',
        descuento:0,
        monto:0,
        total:0,
        subtotal:0,
        productosVendidos: []
      }
    };
  },
  computed: {
    ...mapGetters({
      productoList:'productos/productosFormat',
      tiposVenta:'ventas/tiposVenta',
      clientes:'clientes/clientesFormat'
    }),
    productList(){
      let list=[];
      this.productoList.forEach(e=>{
        if(e.cantidad>0){
            list.push(e);
        }
      })
      return list;
    },
    subtotal: {
      set(value) {
        this.VentaGeneral.subtotal = value;
      },
      get() {
        let subtotal = 0;
        this.VentaGeneral.productosVendidos.forEach(item => {
          subtotal = parseInt(item.subtotal) + parseInt(subtotal) ;
        });
        this.VentaGeneral.subtotal = subtotal;
        return this.VentaGeneral.subtotal;
      }
    },
    total: {
      set(value) {
        this.VentaGeneral.total = value;
      },
      get() {
        let total = this.subtotal - this.VentaGeneral.descuento;
        this.VentaGeneral.total = total;
        this.VentaGeneral.cuotas = total / this.VentaGeneral.monto ;
        return this.VentaGeneral.total;
      }
    }
  },

  created() {
    this.loadData();
    this.eventHub.$on("openModal", rs => {
      this.resetModal();
      this.openTheModal();
    });
  },
  methods: {
    ...mapActions({
      getProductos:'productos/getProductoFormat',
      getClientes:'clientes/getClientesFormat'
    }),
    generateVenta() {
      axios.post(this.url, this.VentaGeneral).then(rs => {
        this.eventHub.$emit("sendVentas");
        this.$noty.success("Nueva venta realizada con exito");
      }).catch(err => {
        this.$noty.error("Ha ocurrido un error al intentar procesar la venta "+err.response.data.message);
      });
    },
    addCuadro() {
      if(!Number.isInteger(this.item.cantidad) || this.item.cantidad < 0 ) return this.$noty.error('Cantidad no válida');
      if(parseInt(this.item.producto.cantidad) < parseInt(this.item.cantidad)) return  this.$noty.error('No hay stock suficiente');

      let precio = (this.VentaGeneral.tipo == 1 )? this.item.producto.precioContado : this.item.producto.precioCredito;
      this.item.subtotal = this.item.cantidad * precio;
      this.VentaGeneral.productosVendidos.forEach(e=>{
        if(e.producto && e.producto.id===this.item.producto.id){
            if((e.producto.cantidad + this.item.cantidad) > e.producto.cantidad){
              this.item.producto='';
              this.item.cantidad='';
              this.item.subtotal='';
              return  this.$noty.error('No hay stock suficiente');
            }else{
              e.cantidad=e.cantidad+this.item.cantidad
            }
            this.item.producto='';

        }
      });

      if(this.item.producto.nombre=='') return this.$noty.warning('Selecciona un producto');
      if(this.item.producto!=='') {
        this.VentaGeneral.productosVendidos.push(this.item)
        this.item = { producto: '', cantidad: '',subtotal:0 };
      }

    },
    deleteProductoVendido(idx) {
      this.VentaGeneral.productosVendidos.splice(idx, 1);
    },
    resetModal() {
      this.VentaGeneral = {
        cliente: "",
        periodo: "",
        tipo: "",
        cuotas: "",
        total: "",
        productosVendidos: []
      };
    },
    loadData() {
      this.getProductos();
      this.getClientes();
    },
    openTheModal() {
      this.$refs.VentaNueva.open();
    },
    closeTheModal() {
      this.$refs.VentaNueva.close();
    }
  }
}
</script>

<style scoped>
.form-group {
  padding: 10px !important;
}
</style>
