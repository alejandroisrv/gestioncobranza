<template>
  <div>
    <bootstrap-modal
      ref="theModal"
      :need-header="true"
      :need-footer="true"
      :size="'large'"
      :opened="resetModal"
    >
      <div slot="title">Nueva Venta</div>

      <div slot="body">
        <form @submit.prevent="send" id="ventaFrom">
          <div class="box-body">
            <div class="row">
              <div class="form-group col-md-6">
                <label>Cliente</label>
                <multiselect
                  v-model="VentaGeneral.cliente"
                  :options="clientes"
                  :custom-label="datosClientes"
                  placeholder="Seleciona un cliente"
                  label="nombre"
                  track-by="nombre"
                ></multiselect>
              </div>
              <div class="form-group col-md-3">
                <label>Tipo de venta</label>
                <select class="form-control" name="tipo_venta" v-model="VentaGeneral.tipo">
                  <option
                    v-for="tipoVenta in tiposVenta"
                    :key="tipoVenta.id"
                    :value="tipoVenta.id"
                  >{{ tipoVenta.descripcion }}</option>
                  <option value="2">Credito</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-4">
                <label>Periodo de pago</label>
                <select class="form-control" name="periodo_pago" v-model="VentaGeneral.periodo">
                  <option value="Semanal">Semanal</option>
                  <option value="Quincenal">Quincenal</option>
                  <option value="Mensual">Mensual</option>
                </select>
              </div>

              <div class="form-group col-md-4">
                <label>Numero de cuotas</label>
                <input type="text" name="cuotas" class="form-control" v-model="VentaGeneral.cuotas">
              </div>
              <div class="form-group col-md-4">
                <label>Monto de las cuotas</label>
                <input type="text" name="cuotas" class="form-control" v-model="VentaGeneral.cuotas">
              </div>
              <div class="col-md-12 mt-3">
                <label>Productos</label>

                <div class="my-3">
                  <div class="row my-3">
                    <div class="col-md-6">
                      <multiselect
                        v-model="new_item.producto"
                        :options="productos"
                        :custom-label="nameWithLang"
                        placeholder="Seleciona un producto"
                        label="nombre"
                        track-by="nombre"
                      ></multiselect>
                    </div>
                    <div class="col-md-5">
                      <input
                        type="text"
                        v-model="new_item.cantidad"
                        id="cantidad"
                        placeholder="Cantidad"
                        class="form-control"
                        @keyup.enter="addCuadro()"
                      >
                    </div>
                    <div class="col-md-1 text-right">
                      <button
                        class="btn btn-primary"
                        type="button"
                        @click.prevent="addCuadro()"
                        style="height:42px !important;"
                      >
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                  </div>
                  <table class="table" v-if="VentaGeneral.productosVendidos.length>1">
                    <thead>
                      <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Sub-total</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr
                        v-for="(productoVendido,idx) in VentaGeneral.productosVendidos"
                        :key="idx+'prod'"
                      >
                        <td>{{ productoVendido.producto.nombre }}</td>
                        <td>{{ productoVendido.cantidad }}</td>
                        <td>{{ productoVendido.subtotal }}</td>
                        <td>
                          <i class="fa fa-times text-danger" @click="deleteProductoVendido(idx)"></i>
                        </td>
                      </tr>
                      <tr>
                        <th>Total: {{ total }}</th>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <button type="submit" style="visibility:hidden;"></button>
          </div>
        </form>
      </div>
      <div slot="footer">
        <button type="button" class="btn btn-default" @click="closeTheModal">Cancelar</button>
        <button type="submit" class="btn btn-primary" @click="send">Guardar</button>
      </div>
    </bootstrap-modal>
  </div>
</template>
<script>
import axios from "axios";
import $ from "jquery";
import { log } from "util";
import Multiselect from "vue-multiselect";
import { totalmem } from "os";
export default {
  data() {
    return {
      url: "/api/ventas",
      tiposVenta: "",
      new_item: { producto: "", cantidad: "", subtotal: "" },
      productos: [],
      clientes: [],
      VentaGeneral: {
        cliente: "",
        periodo: "",
        tipo: "",
        cuotas: 0,
        total: 0,
        productosVendidos: []
      }
    };
  },
  computed: {
    total: {
      set(value) {
        this.VentaGeneral.total = value;
      },
      get() {
        let total = 0;
        this.VentaGeneral.productosVendidos.forEach(item => {
          total += item.subtotal;
        });
        this.VentaGeneral.total = total;
        return this.VentaGeneral.total;
      }
    }
  },
  components: {
    "bootstrap-modal": require("vue2-bootstrap-modal"),
    Multiselect
  },
  created() {
    this.loadData();
    this.eventHub.$on("openModal", rs => {
      this.openTheModal();
    });
  },
  methods: {
    send() {
      axios.post(this.url, this.VentaGeneral).then(rs => {
        this.closeTheModal();
        this.eventHub.$emit("sendProducto");
        this.$noty.success("Nueva venta realizad con exito");
      });
    },
    addCuadro() {
      let precio =
        this.VentaGeneral.tipo == 1
          ? this.new_item.producto.precio_contado
          : this.new_item.producto.precio_credito;
      this.new_item.subtotal = this.new_item.cantidad * precio;
      this.VentaGeneral.productosVendidos.push(this.new_item);
      this.new_item = { producto: "", cantidad: "", subtotal: "" };
    },
    deleteProductoVendido(idx) {
      this.VentaGeneral.productosVendidos.splice(idx, 1);
    },
    getTiposVentas() {
      axios.get("/api/ventas/tipos").then(response => {
        this.tiposVenta = response.data;
      });
    },
    getProductos() {
      axios.get("/api/productos").then(rs => {
        rs.data.forEach(element => {
          this.productos.push({
            id: element.id,
            nombre: element.nombre,
            cantidad: parseInt(element.cantidad),
            precio_contado: parseInt(element.precio_costo),
            precio_credito: parseInt(element.precio_credito)
          });
        });
      });
    },
    getClientes() {
      axios.get("/api/clientes").then(rs => {
        rs.data.forEach(element => {
          this.clientes.push({
            id: element.id,
            nombre: `${element.nombre} ${element.apellido}`
          });
        });
      });
    },

    nameWithLang({ nombre, cantidad, precio_contado, precio_credito }) {
      let precioVenta = (this.VentaGeneral.tipo = 1)
        ? precio_contado
        : precio_credito;
      return `${nombre} disponibles ${cantidad} a ${precioVenta} `;
    },
    datosClientes({ nombre }) {
      return `${nombre}`;
    },
    resetModal() {
      this.VentaGeneral = {
        cliente: "",
        periodo: "",
        tipo: "",
        cuotas: "",
        total: "",
        productosVendidos: [{ producto: "", cantidad: "", subtotal: "" }]
      };
    },
    loadData() {
      this.getTiposVentas();
      this.getProductos();
      this.getClientes();
    },
    openTheModal() {
      this.$refs.theModal.open();
    },
    closeTheModal() {
      this.$refs.theModal.close();
    }
  }
};
</script>

<style scoped>
.form-group {
  padding: 10px !important;
}
</style>

