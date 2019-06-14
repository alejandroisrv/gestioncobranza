<template>
  <div>
    <bootstrap-modal
      ref="entregarModal"
      :need-header="true"
      :need-footer="true"
      :size="'large'"
      :opened="myOpenFunc"
    >
      <div slot="title">Entregar productos</div>

      <div slot="body">
        <form @submit.prevent="send">
          <div class="box-body">
            <div class="col-md-6">
              <label for>Vendedores</label>
              <multiselect
                v-model="vendedor"
                :options="vendedores"
                :custom-label="filtroVendedores"
                placeholder="Seleciona un vendedor"
                label="nombre"
                track-by="nombre"
              ></multiselect>
            </div>
            <div class="col-md-6">
              <label for>Bodega</label>
              <multiselect
                v-model="bodega"
                :options="bodegas"
                :custom-label="filtroBodegas"
                placeholder="Seleciona un bodega"
                label="nombre"
                track-by="nombre"
              ></multiselect>
            </div>
            <div class="col-md-12 mt-3">
              <label>Productos</label>

              <div class="my-3">
                <div class="row my-3">
                  <div class="col-md-6">
                    <multiselect
                      v-model="new_items.producto"
                      :options="productoList"
                      :custom-label="filtroProductos"
                      placeholder="Seleciona un producto"
                      label="nombre"
                      track-by="nombre"
                    ></multiselect>
                  </div>
                  <div class="col-md-5">
                    <input
                      type="text"
                      v-model="new_items.cantidad"
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
                <table class="table" v-if="productosEntregar.length>0">
                  <thead>
                    <tr>
                      <th>Producto</th>
                      <th>Cantidad</th>
                      <th>Sub-total</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="(productoEntregar,idx) in productosEntregar" :key="idx+'prod'">
                      <td>{{ productoEntregar.producto.nombre }}</td>
                      <td>{{ productoEntregar.cantidad }}</td>
                      <td>
                        <i class="fa fa-times text-danger" @click="deleteProductoVendido(idx)"></i>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div slot="footer">
        <button type="button" class="btn btn-default" @click="closeEntregar">Cancelar</button>
        <button type="submit" class="btn btn-primary" @click="send">Guardar</button>
      </div>
    </bootstrap-modal>
  </div>
</template>
<script>
import axios from "axios";
import Multiselect from "vue-multiselect";
import { log } from "util";

import { totalmem } from "os";

export default {
  props: ["productoList"],
  components: {
    "bootstrap-modal": require("vue2-bootstrap-modal"),
    Multiselect
  },
  data() {
    return {
      productosEntregar: [],
      new_items: { producto: '', cantidad: 0 },
      vendedor: "",
      vendedores: [],
      bodega: "",
      bodegas: [],
      cuadros: "",
      productos: []
    };
  },

  created() {
    this.eventHub.$on("openEntregar", () => {
      this.openEntregar();
    });
    console.log(this.productoList);
    
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

      this.productosEntregar.push(this.new_items);
      this.new_items= { producto: '', cantidad: '' };


    },
    deleteProductoVendido(idx) {
      this.productosEntregar.splice(idx, 1);
    },
    filtroProductos({ nombre, cantidad }) {
      return `${nombre} disponible(s) ${cantidad}`;
    },
    filtroVendedores() {},
    filtroBodegas() {},
    myOpenFunc() {},
    openEntregar() {
      this.$refs.entregarModal.open();
    },
    closeEntregar() {
      this.$refs.entregarModal.close();
    }
  }
};
</script>
<style>
.form-control {
  height: 42px !important;
}
</style>

