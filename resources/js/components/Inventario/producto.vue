<template>

  <section class="producto col-md-12">
    <bootstrap-modal ref="detalleModal" :need-header="true" :need-footer="true" :size="'medium'">
      <div slot="title">Detalle del producto</div>
      <div slot="body">
        <div class="box-body">
          <div class="row" v-if="producto.imagen != null ">
            <div class="col-md-12">
              <img :src="'img/productos/' + producto.imagen" class="img-producto-detalle img-thumbnail img-responsive">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4"> <p class="title-detalle mb-0"> {{producto.nombre}}</p> </div>
            <div class="col-md-8"> <p class="descripcion-detalle mb-0">{{producto.descripcion}} </p></div>
          </div>
          <div class="row">
            <div class="col-md-12" v-if="producto.bodega != null">
              <p class="mb-2 mt-1 descripcion-detalle">{{ producto.tipo.label }}</p>
            </div>
          </div>
          <div class="row" v-if="$isAdmin()">
            <div class="col-md-12" v-if="producto.bodega != null"> Bodega: {{producto.bodega.direccion}}</div>
          </div>
          <div class="row">
            <div class="col-md-4" v-if="producto.inicial != null "> Inicial: {{producto.inicial  | currency}}</div>
            <div class="col-md-4"> Comisión: {{producto.comision  | currency}}</div>
            <div class="col-md-4"> Cantidad: {{producto.cantidad}} </div>
          </div>
          <div class="row">
            <div class="col-md-4 pr-0">Precio de costo: {{ producto.precio_costo | currency }} </div>
            <div class="col-md-4 p-0">Precio de contado:  {{producto.precio_contado | currency}} </div>
             <div class="col-md-4 p-0">Precio a credito: {{ producto.precio_credito | currency }} </div>
          </div>
            <div class="row">
                <div class="col-md-6" v-if="producto.precio_credicontado != null" >Precio a credicontado: {{ producto.precio_credicontado | currency }} </div>
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
