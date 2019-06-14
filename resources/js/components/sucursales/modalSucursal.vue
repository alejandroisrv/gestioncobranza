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
                <label>Administrador</label>
                <input required v-model="sucursal.encargado" type="text" class="form-control">
              </div>
              <div class="form-group col-md-6">
                <label>Telefono</label>
                <input required v-model="sucursal.telefono" type="text" class="form-control">
              </div>
            </div>
            <div class="form-group col-md-8">
              <label>Direccion</label>
              <input required v-model="sucursal.direccion" type="text" class="form-control">
            </div>
            <div class="form-group col-md-4">
              <label>Municipio</label>
              <select name="mi" class="form-control" v-model="sucursal.municipio">
                <option value="0">Selecione el minucipio</option>
                <option v-for="(muni,idx) in municipios" :key="idx">{{muni.nombre}}</option>
              </select>
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
  props: ["sucursal", "titulo", "url", "notificacion"],
  data() {
    return {
      show: false,
      municipios: [{ id: 0, nombre: "Bogota" }]
    };
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
      axios.post(this.url, this.sucursal).then(rs => {
        this.closeTheModal();
        this.eventHub.$emit("sendSucursal");
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

