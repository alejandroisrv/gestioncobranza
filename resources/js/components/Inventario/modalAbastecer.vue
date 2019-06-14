<template>
  <div>
    <bootstrap-modal
      ref="abastecerModal"
      :need-header="true"
      :need-footer="true"
      :size="'large'"
      :opened="myOpenFunc"
    >
      <div slot="title">Abastecer inventario</div>

      <div slot="body">
        <form @submit.prevent="send">
          <div class="box-body">
            <button @click="addCuadro" class="btn btn-primary fl-right">Añadir Producto</button>
            <div class="mt-4" id="cuadros" v-for="(new_item,idx) in new_items" :key="idx+'item'">
              <div class="row">
                <div class="col-md-6">
                  <multiselect
                    v-model="new_item.producto"
                    :options="productoList"
                    :custom-label="nameWithLang"
                    placeholder="Seleciona un producto"
                    label="nombre"
                    track-by="nombre"
                  ></multiselect>
                </div>
                <div class="col-md-6">
                  <input
                    type="text"
                    v-model="new_item.cantidad"
                    id="cantidad"
                    placeholder="Cantidad"
                    class="form-control"
                  >
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div slot="footer">
        <button type="button" class="btn btn-default" @click="closeAbastecer">Cancelar</button>
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
      new_items: [{ producto: 0, cantidad: 0 }]
    };
  },
  created() {
    this.eventHub.$on("openAbastercer", () => {
      this.openAbastercer();
    });
  },
  methods: {
    send() {
      axios.post(this.url, this.VentaGeneral).then(rs => {
        this.closeTheModal();
        this.eventHub.$emit("sendProducto");
        this.$noty.success("NuopenAbastecereva venta realizad con exito");
      });
    },
    addCuadro() {
      console.log(this.productosList);
      this.new_items.push( { producto: 0, cantidad: 0 });
    },
    deleteProductoVendido(idx) {
      this.productosVendidos.splice(idx, 1);
    },
    nameWithLang({ nombre, cantidad }) {
      return `${nombre} disponible(s) ${cantidad}`;
    },
    myOpenFunc() {},
    openAbastercer() {
      console.log("assdsadasdsad");
      this.$refs.abastecerModal.open();
    },
    closeAbastecer() {
      this.$refs.abastecerModal.close();
    }
  }
};
</script>
<style>
.form-control {
  height: 42px !important;
}
</style>

