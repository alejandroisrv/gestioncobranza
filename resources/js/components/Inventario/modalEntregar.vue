<template>

  <div>
    <bootstrap-modal ref="entregarModal" :need-header="true" :need-footer="true" size="'large'">
      <div slot="title">Entregar productos</div>
      <div slot="body">
        <form @submit.prevent="sendEntregar">
          <div class="box-body">
            <div class="col-md-12"> <p>Selecciona la bodega para cargar sus productos y vendedores</p> </div>
            <div class="col-md-12">
              <label for>Bodega</label>
              <v-select v-model="datosEnviar.bodega" :options="bodegas" placeholder="Selecciona la bodega"></v-select>
            </div>
            <template v-if="datosEnviar.bodega!=''">
              <div class="col-md-12 my-4" v-if="vendedores && vendedores.length>0">
                <label for v-if="vendedores && vendedores.length>0">Vendedores</label>
                <v-select v-if="vendedores && vendedores.length>0" v-model="datosEnviar.vendedores" :options="vendedores" :multiple="true" placeholder="Selecciona a los vendedores"></v-select>
              </div>
              <div class="col-md-12 my-2" v-else>
                <p class="text-danger">Esta bodega no tiene vendedores.</p>
              </div>
            <div class="col-md-12" v-if="productoList && productoList.length>0">
              <label>Productos</label>
                <div class="row">
                  <div class="col-md-8 my-2">
                    <v-select v-model="new_items.producto" :options="productoList" :clearable="false" placeholder="Selecciona un producto"></v-select>
                  </div>
                  <div class="col-md-2 my-2">
                    <input type="text" v-model.number="new_items.cantidad" placeholder="Cantidad" class="form-control" @keyup.enter="addCuadro()">
                  </div>
                  <div class="col-md-1 text-right my-2">
                    <button class="btn btn-primary" tyype="button" @click.prevent="addCuadro()"> <i class="fa fa-plus"></i></button>
                  </div>
                </div>
                <table class="table" v-if="datosEnviar.productosEntregar.length>0">
                  <thead>
                    <tr>
                      <th>Productos</th>
                      <th>Cantidad</th>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(productoEntregar,idx) in datosEnviar.productosEntregar" :key="idx+'prod'">
                      <td>{{ productoEntregar.producto.label }}</td>
                      <td>{{ productoEntregar.cantidad }}</td>
                      <td>
                        <i class="fa fa-times text-danger" @click="deleteProductoVendido(idx)"></i>
                      </td>
                    </tr>
                  </tbody>
                </table>
            </div>
            </template>
          </div>
        </form>
      </div>

      <div slot="footer">
        <button type="button" class="btn btn-default" @click="closeEntregar">Cancelar</button>
        <button type="submit" class="btn btn-primary" @click="sendEntregar">Guardar</button>
      </div>
    </bootstrap-modal>
  </div>

</template>
<script>
  import {mapGetters,mapActions} from 'vuex';
  import axios from 'axios';
  import ProductoService from '../../services/productos.js';
  export default {
    components: {
      'bootstrap-modal': require('vue2-bootstrap-modal')
    },
    data() {
      return {
        datosEnviar:{
            vendedores:'',
            bodega: '',
            productosEntregar: [],
        },
        new_items: { producto: '', cantidad: ''},
      }
    },
    computed:{
      ...mapGetters({
        productoList: 'productos/productosFormat',
        bodegas:'bodegas/bodegasFormat',
        vendedores:'users/usersFormat'
      }),

    },
    created() {
      this.getBodegas();
      this.eventHub.$on('openEntregar', () => {
         this.openEntregar()
      })
    },
    methods: {
      ...mapActions({
        getBodegas:'bodegas/getBodegasFormat'
      }),
      sendEntregar() {
        console.log(this.datosEnviar);
        let validate = !(this.datosEnviar.productosEntregar.length==0);
        let e = (validate) ? ProductoService.entregarProductos(this.datosEnviar) : false;
        if(!e) return this.$noty.error('Se ha producido un error al intentar entregar los producto');
        this.closeEntregar();
        this.$noty.success('Se ha entregado el producto con exito');
        this.datosEnviar={vendedores:'',bodega: '',productosEntregar:[]};
        this.eventHub.$emit("initProductos");
      },
      addCuadro() {
        console.log(this.datosEnviar);
        this.datosEnviar.productosEntregar.forEach(e => {
          if(this.new_items.producto.id==e.producto.id){
            e.cantidad+=this.new_items.cantidad;
            this.new_items = { producto:'', cantidad:''};
          }
        });
        if(parseInt(this.new_items.cantidad)<0 || this.new_items.cantidad==''){
           this.$noty.error('Debe ingresar una cantidad mayor a 0');
           return false;
         }
         if(this.new_items.producto == ""){
            this.$noty.warning('Selecciona un producto');
            return false;
         }
         if(parseInt(this.new_items.producto.cantidad) < parseInt(this.new_items.cantidad)){
            this.$noty.error('No hay stock suficiente');
            return false;
         }

        this.datosEnviar.productosEntregar.push(this.new_items)
        this.new_items = { producto: '', cantidad: '' }
      },
      deleteProductoVendido(idx) {
        this.datosEnviar.productosEntregar.splice(idx, 1)
      },
      openEntregar() {
        this.$refs.entregarModal.open()
      },
      closeEntregar() {
        this.$refs.entregarModal.close();

      }
    },
    watch:{
      "datosEnviar.bodega"(){
        let query= (this.datosEnviar.bodega && this.datosEnviar.bodega.id) ? { bodega: this.datosEnviar.bodega.id, tipo: 4} : {}
        this.$store.dispatch('productos/getProductoFormat', query );
        this.$store.dispatch('users/getUsersFormat', query );
      }

    }
  }

</script>
