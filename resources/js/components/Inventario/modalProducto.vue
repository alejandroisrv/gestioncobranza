<template>
  <div>
    <bootstrap-modal ref="NuevoProducto" :need-header="true" :need-footer="true" :size="'large'">
      <div slot="title">{{ titulo }}</div>
      <div slot="body">
        <form @submit.prevent="send()">
          <div class="box-body" v-if="producto!=''">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Nombre</label>
                <input required v-model="producto.nombre" type="text" class="form-control">
              </div>
              <div class="form-group col-md-6">
                <label>Comision</label>
                  <money v-model="producto.comision"></money>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-5">
                <label>Descripción</label>
                <input required v-model="producto.descripcion" type="text" class="form-control">
              </div>
                <div class="form-group col-md-3">
                    <label>Inicial</label>
                    <money v-model="producto.inicial"></money>
                </div>
              <div class="form-group col-md-4">
                <label>Tipo de producto</label>
                <v-select v-model="producto.tipo" :options="tipoProductos" placeholder="Selecciona el tipo de producto"></v-select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label>Precio de costo</label>
                  <money v-model="producto.precio_costo"></money>
              </div>
              <div class="form-group col-md-3">
                <label>Precio de contado</label>
                  <money v-model="producto.precio_contado"></money>
              </div>
              <div class="form-group col-md-3">
                <label>Precio a credito</label>
                  <money v-model="producto.precio_credito"></money>
              </div>
                <div class="form-group col-md-3">
                    <label>Precio credicontado</label>
                    <money v-model="producto.precio_credicontado"></money>
                </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                  <input @change="previewFiles" type="file" name="productoImagen" ref="inputImg" id="file-img" style="display:none;">
                  <button class="btn btn-primary" @click="loadImg" type="button">
                    <i class="fa fa-image mr-1"></i>  Selecciona una imagen
                  </button>
              </div>
            </div>
            <div class="form-row" v-if="img !== ''">
              <div class="form-group form-group text-left col-md-8" style="padding-top:0px!important;">
                  <span class="deleteImg" @click="deleteImg()"> &times; </span>
                  <img class="img-preview" id="preview-img" :src="previewImg" />
              </div>
            </div>
          </div>
          <button type="submit" style="visibility:hidden;"></button>
        </form>
      </div>
      <div slot="footer">
        <button type="button" class="btn btn-default" @click="closeTheModal">Cancelar</button>
        <button type="submit" class="btn btn-primary" @click="send" :disabled="sending"><span v-if="!sending">Guardar</span><span v-else><i>Enviando...</i></span></button>
      </div>
    </bootstrap-modal>
  </div>
</template>
<script>
import axios from "axios";
import $ from 'jquery';
export default {
  props: ["titulo", "url","notificacion"],
  data() {
    return {
       previewImg:'',
       img:'',
       show: false,
       tipoProductos:[],
       producto:'',
       sending:false
      }
  },
  components: {
    "bootstrap-modal": require("vue2-bootstrap-modal")
  },
  created() {
    this.eventHub.$on("openModal", producto => {
      this.producto = producto;
      if(this.producto.image != ''){
        this.img = this.producto.imagen;
        this.previewImg = 'img/productos/' + this.producto.imagen;
      }
      this.modalPoducto();

    });

    this.getTipos();
  },
  methods: {

    send() {

      if(this.producto.nombre == ''){
        this.$noty.error('Debes introducir un nombre al producto');
        return false;
      }

      if(this.producto.comision == ''){
        this.$noty.error('Debes introducir la comisión a pagar por el producto ');
        return false;
      }

      if(this.producto.descripcion == ''){
        this.$noty.error('Debes introducir una descripcion al producto');
        return false;
      }

      if(!this.producto.tipo == undefined){
        this.$noty.error('Debes seleccionar un tipo de producto');
        return false;
      }

      if(this.producto.precio_contado == ''){
        this.$noty.error('Debes introducir el precio de contado del producto');
        return false;
      }

      if(this.producto.precio_costo == ''){
        this.$noty.error('Debes introducir el precio de costo del producto');
        return false;
      }

      if(this.producto.precio_credito == ''){
        this.$noty.error('Debes introducir el precio del producto a credito');
        return false;
      }
      console.log(this.producto);

      let formData = new FormData();
      formData.append('nombre', this.producto.nombre);
      formData.append('comision', this.producto.comision);
      formData.append('descripcion', this.producto.descripcion);
      formData.append('tipo', this.producto.tipo.id);
      formData.append('inicial', this.producto.inicial);
      formData.append('precio_costo', this.producto.precio_costo);
      formData.append('precio_contado', this.producto.precio_contado);
      formData.append('precio_credito', this.producto.precio_credito);
      formData.append('precio_credicontado', this.producto.precio_credicontado)
      formData.append('productoImagen', this.img);
      this.sending = true;

      axios.post(this.url,formData,{ headers:{'Content-Type': 'multipart/form-data'}})
      .then(rs =>{
        this.eventHub.$emit("initProductos");
        this.$noty.success(this.notificacion);
        this.closeTheModal();
      }).catch(err =>{
          this.$noty.error('Se ha producido un error');
      }).finally(fl => this.sending = false );
    },
    getTipos(){
      axios.get('/api/productos/tipos-list').then(rs=> {
        this.tipoProductos = rs.data;
      }).catch(err=> {
        this.$noty.error('Se ha producido un error al intentar');
      })
    },
    previewFiles(e) {
      this.img = e.target.files[0];
      this.previewImg = URL.createObjectURL(this.img);
    },
    deleteImg(){
      this.img = '';
      this.previewImg = '';
    },
    loadImg() {
      this.$refs.inputImg.click();
    },
    modalPoducto() {
      this.$refs.NuevoProducto.open();
    },
    closeTheModal() {
      this.$refs.NuevoProducto.close();
    },
  }
};
</script>

<style scoped>
.form-group {
  padding: 10px !important;
}

.img-preview{
  width:280px;
  height:200px;
  display:block;
  max-width:100%;
}

.deleteImg{
  cursor: pointer;
  font-size: 20px;
  font-weight: 400;
  display: block;
  margin-left: 255px;
}
</style>
