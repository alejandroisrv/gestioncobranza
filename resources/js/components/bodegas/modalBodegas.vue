<template>
  <div>
    <bootstrap-modal ref="theModal" :need-header="true" :need-footer="true" :size="'large'">
      <div slot="title">{{ titulo }}</div>
      <div slot="body">
        <form @submit.prevent="send">
          <div class="box-body">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Encargado</label>
                <v-select v-model="bodega.encargado" :options="encargados"></v-select>
              </div>
              <div class="form-group col-md-6">
                <label>Telefono</label>
                <input required v-model="bodega.telefono" type="text" class="form-control">
              </div>
            </div>
            <div class="form-group col-md-8">
              <label>Dirección</label>
              <input required v-model="bodega.direccion" type="text" class="form-control">
            </div>
            <div class="form-group col-md-4">
              <label>Municipio</label>
              <select name="mi" class="form-control" v-model="bodega.municipio_id">
                <option value="0">Selecione el minucipio</option>
                <option v-for="muni in municipios" :key="muni.id" :value="muni.id">{{muni.municipio}}</option>
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
import {mapGetters,mapActions } from 'vuex';
export default {
  props: ["bodega", "titulo", "url", "notificacion"],
  data() {
    return {
      //municipios: [{ id: 0, nombre: "Bogota" }],
    };
  },
  components: {
    "bootstrap-modal": require("vue2-bootstrap-modal")
  },
  computed:{
    ...mapGetters({encargados:'users/usersFormat',municipios:'municipios/municipios'})
  },
  created() {
    this.getEncargados();
    this.eventHub.$on("openModal", rs => {
      this.openTheModal();
    });
  },
  methods: {
    ...mapActions({getEncargados:'users/getUsersFormat'}),
    send() {
      axios.post(this.url, this.bodega).then(rs => {
        this.closeTheModal();
        this.eventHub.$emit("sendBodegas");
        this.$noty.success(this.notificacion);
      });
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
