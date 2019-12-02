<template>
  <div>
    <bootstrap-modal ref="NuevaBodega" :need-header="true" :need-footer="true" :size="'large'">
      <div slot="title">{{ titulo }}</div>
      <div slot="body">
        <form @submit.prevent="send">
          <div class="box-body">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Encargado</label>
                <v-select v-model="bodega.encargado" :options="encargados" placeholder="Selecciona el encargado de esta bodega"></v-select>
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
              <select class="form-control" v-model="bodega.municipio_id">
                <option  selected value="">Selecione el minucipio</option>
                <option  v-if="muni.id !='all'"  v-for="(muni,idx) in municipios" :key="idx+'municipio'" :value="muni.id">{{muni.label}}</option>
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

import api from '../../services/api';

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
    ...mapGetters({encargados:'users/usersFormat',municipios:'municipios/municipiosFormat'})
  },
  created() {
    this.getEncargados({tipo:2});
    this.eventHub.$on("openModal", rs => {
      this.openTheModal();
    });
  },
  methods: {
    ...mapActions({getEncargados:'users/getUsersFormat'}),
    send() {

        if(this.bodega.encargado == undefined && this.bodega.encargado == null ){
            this.$noty.error('Debe seleccionar un encargado para esta bodega');
            return false;
        }

        if(this.bodega.direccion == ''){
            this.$noty.error('Debes agregar una direccion para esta bodega');
            return false;
        }

        if(this.bodega.municipio_id == ''){
            this.$noty.error('Debes agregar una direccion para esta bodega');
            return false;
        }

        this.bodega.encargado_id = this.bodega.encargado.id

          api().post(this.url, this.bodega).then(rs => {
            this.closeTheModal();
            this.eventHub.$emit("sendBodegas");
            this.$noty.success(this.notificacion);
          });
    },
    openTheModal() {
      this.$refs.NuevaBodega.open();
    },
    closeTheModal() {
      this.$refs.NuevaBodega.close();
    }
  }
};
</script>

<style scoped>
.form-group {
  padding: 10px !important;
}
</style>
