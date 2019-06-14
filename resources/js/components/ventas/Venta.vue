<template>
  <div>
        <bootstrap-modal  ref="ventaDetalle"
      :need-header="true"
      :need-footer="true"
      :size="'large'"
      :opened="myOpenFunc"
    >
      <div slot="title">{{ titulo }}</div>

      <div slot="body">
        <div class="row">
          <div class="col-12">
            <table>
              <tr>
                <td> Fecha: {{ fec }}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div slot="footer">
        <button type="button" class="btn btn-default" @click="closeTheModal">Cancelar</button>
        <button type="submit" class="btn btn-primary" @click="send">Guardar</button>
      </div>
    </bootstrap-modal>
  </div>
</template>
<script>
import $ from "jquery";
import { log } from "util";
import { totalmem } from "os";
export default {
    props: ['titulo','venta'],
    components: {
    "bootstrap-modal": require("vue2-bootstrap-modal")
  },
  created() {
    this.eventHub.$on("openVentaModal", () => {
      this.openTheModalVenta();
    });
  },
  methods: {
    openTheModalVenta() {
       console.log(this.$refs);
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

