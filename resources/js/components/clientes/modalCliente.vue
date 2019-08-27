<template>
  <div>
    <bootstrap-modal ref="ClienteModal" :need-header="true" :need-footer="true" :size="'large'" :opened="myOpenFunc">
      <div slot="title">{{ titulo }}</div>
      <div slot="body">
        <form @submit.prevent="send">
          <div class="box-body">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label>Nombre y apellido</label>
                <input required v-model="cliente.nombre" type="text" class="form-control">
              </div>
              <div class="form-group col-md-4">
                <label>Cédula</label>
                <input required v-model="cliente.cedula" type="text" class="form-control">
              </div>
               <div class="form-group col-md-4">
                <label>Telefono</label>
                <input required v-model="cliente.telefono" type="text" class="form-control">
              </div>
            </div>
            <div class="form-group col-md-8">
              <label>Dirección</label>
              <input required v-model="cliente.direccion" type="text" class="form-control">
            </div>
            <div class="form-group col-md-4">
              <label>Municipio</label>
              <v-select :options="listMunicipios" v-model="cliente.municipio" placeholder="Seleccione el municipio" />
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>E-mail</label>
                <input required v-model="cliente.email" type="text" class="form-control">
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
import { mapGetters } from 'vuex';
export default {
  props: ["titulo", "url", "notificacion"],
  data() {
    return {
      show: false,
      cliente:''
    };
  },
  computed:{
    ...mapGetters({municipios:'municipios/municipiosFormat'}),
    listMunicipios(){
      let arr = [];
      this.municipios.forEach(element => {
        if(element.label != 'Todos'){
          arr.push(element)
        }
      });
      return arr;
    }
  },
  components: {
    "bootstrap-modal": require("vue2-bootstrap-modal")
  },
  created() {
    this.eventHub.$on("openModal", rs => {
      this.cliente = rs;
      console.log(rs);
      this.openTheModal();
    });
  },
  methods: {
    send() {
      
      if(this.cliente.nombre == ''){
        this.$noty.error('Debe colocarle un nombre al cliente');
        return false;
      }

      if(this.cliente.direccion == ''){
        this.$noty.error('Debe ingresar una direccion para el cliente');
        return false;
      }

      if(this.cliente.cedula == ''){
        this.$noty.error('Debe ingresar la cedula del cliente');
        return false;
      }
      
      if(this.cliente.telefono == ''){
        this.$noty.error('Debe ingresar el telefono del cliente');
        return false;
      }

      if(this.cliente.municipio == undefined && this.cliente.municipio == null ){
        this.$noty.error('Debe seleccionar un minicipio para el cliente');
        return false;
      }

      this.cliente.municipio_id = this.cliente.municipio.id;

      axios.post(this.url, this.cliente).then(rs => {
        this.eventHub.$emit("sendCliente");
        this.$noty.success(this.notificacion);
        this.closeTheModal();
      }).catch(err => {
        this.$noty.error("Ha ocurrido un error al intentar agregar al cliente "+err.response.data.message);
      });
    },
    openTheModal() {
      this.$refs.ClienteModal.open();
    },
    myOpenFunc() {
      console.log("hello");
    },
    closeTheModal() {
      this.$refs.ClienteModal.close();
    }
  }
};
</script>

<style scoped>
.form-group {
  padding: 10px !important;
}
</style>
