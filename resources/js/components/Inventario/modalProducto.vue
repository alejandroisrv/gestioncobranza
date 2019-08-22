<template>
  <div>
    <bootstrap-modal
      ref="NuevoProducto"
      :need-header="true"
      :need-footer="true"
      :size="'large'"
      :opened="myOpenFunc"
    >
      <div slot="title">{{ titulo }}</div>

      <div slot="body">
        <form @submit.prevent="send()">
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
              <label>Descripción</label>
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
            <div class="form-row">
              <div class="form-group col">
                  <input @change="previewFiles(e)" type="file" name="productoImagen" ref="inputImg" style="display:none;">
                  <button class="btn btn-primary" @click="loadImg" type="button">Selecciona una imagen <i class="fa fa-image"></i> </button>
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
    return { img:'',show: false };
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
      let formData = new FormData();
      formData.append('nombre', this.producto.nombre);
      formData.append('comision', this.producto.comision);
      formData.append('descripcion', this.producto.descripcion);
      formData.append('precio_costo', this.producto.precio_costo);
      formData.append('precio_contado', this.producto.precio_contado);
      formData.append('precio_credito', this.producto.precio_credito);
      formData.append('productoImagen', this.img);
      
      axios.post(this.url,formData,{ headers:{'Content-Type': 'multipart/form-data'}}).then(rs => {
        this.eventHub.$emit("initProductos");
        this.closeTheModal();
        this.$noty.success(this.notificacion);
      });
    },
    previewFiles(e) {
      const file = e.target.files[0];
      this.img = file;
    },
    loadImg() {
      this.$refs.inputImg.click();
    },
    openTheModal() {
      this.$refs.NuevoProducto.open();
    },
    myOpenFunc() {
      console.log("hello");
    },
    closeTheModal() {
      this.$refs.NuevoProducto.close();
    }
  }
};
</script>

<style scoped>
.form-group {
  padding: 10px !important;
}
</style>
