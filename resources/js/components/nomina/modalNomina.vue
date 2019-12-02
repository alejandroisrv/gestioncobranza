
<template>
  <bootstrap-modal ref="addtrabajador" :need-header="true" :need-footer="true" :size="'large'">
    <div slot="title"><span v-if="!editando">Nuevo Trabajador</span> <span v-else> Editar trabajador</span></div>
    <div slot="body">
      <div class="box-body" v-if="trabajador!=''">
        <form @submit.prevent="send">
        <div class="form-row">
          <div class="form-group col-md-4 col-lg-4">
            <label>Nombre</label>
            <input type="text" name="cuotas" class="form-control" v-model="trabajador.name">
          </div>
          <div class="form-group col-md-4 col-lg-4">
            <label>Cédula</label>
            <input type="text" name="cuotas" class="form-control" v-model="trabajador.cedula">
          </div>
          <div class="form-group col-md-4 col-lg-4">
            <label>Teléfono</label>
            <input type="text" name="cuotas" class="form-control" v-model="trabajador.telefono">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-7 col-lg-7">
            <label>Direccion</label>
            <input type="text" name="cuotas" class="form-control" v-model="trabajador.direccion">
          </div>
          <div class="form-group col-md-5 col-lg-5">
            <label>E-mail</label>
            <input type="text" name="cuotas" class="form-control" v-model="trabajador.correo">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4 col-lg-4">
            <label>Sucursal</label>
            <v-select v-model="trabajador.sucursal" :options="sucursales" placeholder="Seleccione una sucursal para este usuario"></v-select>
          </div>
          <!--<div class="form-group col-md-4 col-lg-4">
            <label>Bodega</label>
            <v-select v-model="trabajador.bodega" :options="bodegas" placeholder="Seleccione una bodega para este usuario"></v-select>
          </div>-->
          <div class="form-group col-md-4 col-lg-4">
            <label>Rol</label>
            <v-select v-model="trabajador.rol" :options="roles" placeholder="Seleccione un rol para este usuario"></v-select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-5 col-lg-5">
            <label>Usuario</label>
              <template v-if="!editando">
                <input type="text" name="cuotas" class="form-control" v-model="trabajador.email">
                <small class="text-muted"> La contraseña por defecto será del 1 al 6, puedes cambiarla luego.</small>
              </template>
              <template v-else>
                <input type="text" name="cuotas" class="form-control" v-model="trabajador.email" disabled>
              </template>
          </div>
        </div>
        <button type="submit" class="btn btn-primary" style="display:none"></button>
        </form>
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
      editando:false,
      trabajador:{},
      loading: true,
      roles: [],
      bodegas:[],
      sucursales:[]
    };
  },
  created() {
    //ABRIR
    this.getRoles(null);
    this.getSucursales();
    // this.getBodegas();
    this.eventHub.$on("addTrabajador", (item,editando) => {
      this.editando = editando;
      if(editando){
        item.rol.label = item.rol.name;
        item.sucursal.label  = item.sucursal.direccion;
        item.bodega.label  = item.bodega.direccion;
      }
      this.trabajador = item;
      this.open();

    });
  },
  components: {
    "bootstrap-modal": require("vue2-bootstrap-modal")
  },
  computed: {},
  methods: {
    async getBodegas(sucursal){
      const rs  = await BodegaService.getAll({ sucursal: sucursal });
      rs.data.body.data.forEach(e => {
        e.label = e.direccion;
      });
      this.bodegas=rs.data.body.data;
    },
    async getRoles() {
      const rs = await NominaService.roles();
      rs.data.forEach(e => {
        e.label = e.name;
      });
      this.roles = rs.data;
    },
    async getSucursales(){
      const rs = await SucursalService.getAll();
      rs.data.body.data.forEach(e => {
        e.label = e.direccion;
      });
      this.sucursales = rs.data.body.data;
    },
    async send() {

      if(this.trabajador.nombre == ''){
        this.$noty.error('Debe colocarle un nombre al trabajador');
        return false;
      }

      if(this.trabajador.direccion == ''){
        this.$noty.error('Debe ingresar una direccion para el trabajador');
        return false;
      }

      if(this.trabajador.cedula == ''){
        this.$noty.error('Debe ingresar la cedula del trabajador');
        return false;
      }

      if(this.trabajador.telefono == ''){
        this.$noty.error('Debe ingresar el telefono del trabajador');
        return false;
      }

      if(this.trabajador.email == ''){
        this.$noty.error('Debe ingresar un usuario para el trabajador');
        return false;
      }

      if(this.trabajador.sucursal == undefined && this.trabajador.sucursal == null ){
        this.$noty.error('Debe seleccionar una sucursal para el trabajador');
        return false;
      }

      /*if(this.trabajador.bodega == undefined && this.trabajador.bodega == null ){
        this.$noty.error('Debe seleccionar una bodega para el trabajador');
        return false;
      }*/

      if(this.trabajador.rol == undefined && this.trabajador.rol == null ){
        this.$noty.error('Debe seleccionar un rol para el trabajador');
        return false;
      }

      this.trabajador.sucursal_id = this.trabajador.sucursal.id;
      //this.trabajador.bodega_id = this.trabajador.bodega.id;
      this.trabajador.role = this.trabajador.rol.id;
      try {
        const rs = (this.editando) ? await NominaService.edit(this.trabajador) : await NominaService.add(this.trabajador);
        if (rs.data.response == "ok") {
          this.eventHub.$emit('getNomina');
          this.$noty.success((this.editando) ? "Tabajador editado con éxito" : "Añadido con exito");
          this.close();
        }
      } catch (error) {
        this.$noty.error("Se ha producido un error" + rs.data.response);
      }


    },
    open() {
      this.$refs.addtrabajador.open();
    },
    close() {
      this.$refs.addtrabajador.close();
    }
  },
  watch:{
    "trabajador.sucursal"(){
      if(this.trabajador.sucursal !== undefined && this.trabajador.sucursal !== null ){
        this.getBodegas(this.trabajador.sucursal.id);
      }else{
        this.bodegas = [];
      }
    }
  }
};
</script>
