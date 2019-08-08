
<template>
  <bootstrap-modal ref="addtrabajador" :need-header="true" :need-footer="true" :size="'large'">
    <div slot="title">Nuevo Trabajador</div>
    <div slot="body">
      <div class="box-body" v-if="trabajador!=''">
        <div class="row">
          <div class="col-md-12">
            <h4>Datos del Tabajador</h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 col-lg-4 my-1">
            <label>Nombre</label>
            <input type="text" name="cuotas" class="form-control" v-model="trabajador.name">
          </div>
          <div class="col-md-4 col-lg-4 my-1">
            <label>Cédula</label>
            <input type="text" name="cuotas" class="form-control" v-model="trabajador.cedula">
          </div>
          <div class="col-md-4 col-lg-4 my-1">
            <label>Teléfono</label>
            <input type="text" name="cuotas" class="form-control" v-model="trabajador.telefono">
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-6 my-1">
            <label>Direccion</label>
            <input type="text" name="cuotas" class="form-control" v-model="trabajador.direccion">
          </div>
          <div class="col-md-4 col-lg-4 my-1">
            <label>E-mail</label>
            <input type="text" name="cuotas" class="form-control" v-model="trabajador.correo">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 col-lg-4 my-1">
            <label>Sucursal</label>
            <v-select v-model="trabajador.sucursal_id" v-if="sucursales.length>0" :options="sucursales" placeholder="Seleccione una sucursal para este usuario"></v-select>
          </div>
          <div class="col-md-4 col-lg-4 my-1">
            <label>Rol</label>
            <v-select v-model="trabajador.rol" v-if="roles && roles.length>0" :options="roles" placeholder="Seleccione un rol para este usuario"></v-select>
          </div>
          <div class="col-md-4 col-lg-4 my-1">
            <label>Bodega</label>
            <v-select v-model="trabajador.bodega_id" v-if="bodegas.data && bodegas.data.length>0" :options="bodegas.data" placeholder="Seleccione una bodega para este usuario"></v-select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 col-lg-4 my-1">
            <label>Usuario</label>
            <input type="text" name="cuotas" class="form-control" v-model="trabajador.email">
          </div>
        </div>
      </div>
    </div>
    <div slot="footer">
      <button type="button" class="btn btn-default" @click="close">Cancelar</button>
      <button type="button" class="btn btn-primary" @click="send">Guardar</button>
    </div>
  </bootstrap-modal>
</template>


<script>
import { mapGetters, mapActions } from "vuex";
import NominaService from "../../services/nomina";
import BodegaService from '../../services/bodegas';
import SucursalService from '../../services/sucursales';

export default {
  data() {
    return {
      trabajador: {
        name: "",
        direccion: "",
        telefono: "",
        cedula: "",
        rol: "",
        sucursal_id:'',
        bodega_id:'',
        email: ""
      },
      loading: true,
      roles: [],
      bodegas:[],
      sucursales:[]
    };
  },
  created() {
    //ABRIR
    this.getRoles();
    this.getSucursales();
    this.eventHub.$on("addTrabajador", () => {
      this.open();
    });
  },
  components: {
    "bootstrap-modal": require("vue2-bootstrap-modal")
  },
  computed: {},
  methods: {
    async getRoles() {
      const rs = await NominaService.roles();
      rs.data.forEach(e => {
        e.label = e.name;
      });
      this.roles = rs.data;
      this.loading = false;
    },
    async getSucursales(){
      const rs = await SucursalService.getAll();
      rs.data.forEach(e => {
        e.label = e.direccion;
      });
      console.log(rs);
      this.sucursales = rs.data
    },
    async send() {
      const rs = await NominaService.add(this.trabajador);
      if (rs.data.response == "ok") {
        this.$noty.success("Añadido con exito");
      } else {
        this.$noty.error("Error al intentar añadir" + rs.data.response);
      }
    },
    async getBodegas(sucursal){
      let query = { sucursal: sucursal };
      const rs= await BodegaService.getAll(query);
      rs.data.body.data.forEach(e => {
        e.label = e.direccion;
      });
      console.log(rs);
      
      this.bodegas=rs.data.body
    },

    open() {
      this.$refs.addtrabajador.open();
    },
    close() {
      this.$refs.addtrabajador.close();
    }
  },
  watch:{
    "tabajador.rol"(){
      if(this.trabajador.rol.slug="administrador-de-bodegas"){
        this.getBodegas(this.trabajador.sucursal_id);
      }
    }
  }
};
</script>
