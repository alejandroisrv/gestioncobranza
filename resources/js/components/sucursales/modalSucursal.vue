<template>
  <div>
    <bootstrap-modal ref="theModal" :need-header="true" :need-footer="true" :size="'large'">
      <div slot="title">{{ titulo }}</div>

      <div slot="body">
        <form @submit.prevent="send">
          <div class="box-body" v-if="show">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Administrador</label>
                <v-select v-model="sucursal.encargado" :options="encargados" placeholder="Selecciona el encargado"></v-select>
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
                <option value="0" selected>Selecione el minucipio</option>
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
import {mapGetters,mapActions} from 'vuex';
export default {
  props: ["titulo", "url", "notificacion"],
  data() {
    return {
      sucursal:{
        encargado: "",
        direccion: "",
        minicipio: "",
        telefono: ""
      },
      show: false,
    };
  },
  components: {
    "bootstrap-modal": require("vue2-bootstrap-modal")
  },
  computed:{
    ...mapGetters({encargados:'users/usersFormat',municipios:'municipios/municipiosFormat'}),
  },
  created() {
    this.getEncargados();
    this.eventHub.$on("openModal", rs => {
      this.show = true;
      this.sucursal = rs;
      this.openTheModal();
    });
  },
  methods: {
    ...mapActions({getEncargados:'users/getUsersFormat'}),
    send() {
      axios.post(this.url, this.sucursal).then(rs => {
        this.eventHub.$emit("sendSucursal");
        this.$noty.success(this.notificacion);
        this.closeTheModal();
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
