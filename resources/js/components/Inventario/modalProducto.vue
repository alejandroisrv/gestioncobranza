<template>
  <div>
    <bootstrap-modal
      ref="theModal"
      :need-header="true"
      :need-footer="true"
      :size="'large'"
      :opened="myOpenFunc"
    >
      <div slot="title">{{ titulo }}</div>

      <div slot="body">
        <form @submit.prevent="send">
          <div class="box-body">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Nombre</label>
                <input required v-model="producto.nombre" type="text" class="form-control">
              </div>
              <div class="form-group col-md-6">
                <label>Comision</label>
                <input required v-model="producto.comision" type="text" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label>Descripcion</label>
              <input required v-model="producto.descripcion" type="text" class="form-control">
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label>Precio de costo</label>
                <input required v-model="producto.precio_costo" type="text" class="form-control">
              </div>
              <div class="form-group col-md-4">
                <label>Precio de contado</label>
                <input required v-model="producto.precio_contado" type="text" class="form-control">
              </div>
              <div class="form-group col-md-4">
                <label>Precio a credito</label>
                <input required v-model="producto.precio_credito" type="text" class="form-control">
              </div>
            </div>
          </div>
          <button type="submit" style="visibility:hidden;"></button>
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
export default {
  props: ["producto", "titulo", "url","notificacion"],
  data() {
    return { show: false };
  },
  components: {
    "bootstrap-modal": require("vue2-bootstrap-modal")
  },
  created() {
    this.eventHub.$on("openModal", rs => {
      this.openTheModal();
    });
  },
  methods: {
    send() {
      axios.post(this.url, this.producto).then(rs => {
        this.closeTheModal();
        this.eventHub.$emit("sendProducto");
        this.$noty.success(this.notificacion);
      });
    },
    openTheModal() {
      this.$refs.theModal.open();
    },
    myOpenFunc() {
      console.log("hello");
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

