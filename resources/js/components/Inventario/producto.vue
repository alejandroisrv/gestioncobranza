<template>

  <section class="producto col-md-12">
    <bootstrap-modal ref="detalleModal" :need-header="true" :need-footer="true" :size="'medium'">
      <div slot="title">Detalle del producto</div>
      <div slot="body">
        <div class="box-body">
          <div class="row">
            <div class="col-md-4"> <p class="title-producto"> {{producto.nombre}}</p> </div>
            <div class="col-md-8"> <p class="descripcion-producto">{{producto.descripcion}} </p></div>
          </div>
          <div class="row" v-if="$isAdmin()">
            <div class="col-md-12" v-if="producto.bodega != null"> Bodega: {{producto.bodega.direccion}} </p></div>
          </div>
          <div class="row">
            <div class="col-md-4"> Disponibilidad: {{producto.cantidad}} </div>
            <div class="col-md-4"> Comisión: {{producto.comision  | currency}}</div>
          </div>
          <div class="row">
            <div class="col-md-4"> Precio a contado: {{ producto.precio_contado | currency }} </div>
            <div class="col-md-4">Precio a crédito {{producto.precio_credito | currency}} </div>
          </div>
        </div>
      </div>
      <div slot="footer">
        <button @click="closeDetalle" class="btn btn-primary">Continuar</button>
      </div>
    </bootstrap-modal>
  </section>

</template>

<script lang="js">
  export default  {
    props: ['producto'],
    components: {
      "bootstrap-modal": require("vue2-bootstrap-modal")
    },
    created(){
      this.eventHub.$on("detalleProducto", () => {
        this.openDetalle();
      });
    },
    methods: {
      openDetalle() {
        this.$refs.detalleModal.open();
      },
      closeDetalle() {
        this.$refs.detalleModal.close();
      }
    },
}
</script>

<style scoped>
  .title-producto {
    font-size:18px !important;
    font-weight:600;
  }
  .descripcion-producto {
    font-size:16px !important;
    font-weight:400;
  }

</style>
