<template>
  <div>
    <bootstrap-modal ref="abastecerModal" :need-header="true" :need-footer="true" :size="'medium'">
      <div slot="title">Abastecer inventario</div>
      <div slot="body">
          <div class="box-body">
              <div class="row">
                <div class="col-md-12 col-xs-12"><p v-if="$isAdmin">Selecciona la bodega para cargar los productos </p> <p v-else> Selecciona los productos para abastecer </p></div>
              </div>
              <template  v-if="$isAdmin">
                  <div class="row">
                      <div class="col-md-8 col-xs-8 mt-2 mb-4"><v-select v-model="params.bodega" :options="bodegas" placeholder="Selecciona la bodega" /> </div>
                  </div>
                  <div class="row justify-content-between" v-if="params.bodega != null">
                      <div class="col-md-6 col-xs-6" >
                          <v-select v-model="item.producto" :options="productosList" placeholder="Selecciona el producto"></v-select>
                      </div>
                      <div class="col-md-4 col-xs-4">
                          <input type="text" @keyup.enter="addCuadro" v-model.number="item.cantidad" id="cantidad" placeholder="Cantidad" class="form-control">
                      </div>
                      <div class="col-md-2 col-xs-2">
                          <button @click="addCuadro" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                      </div>
                  </div>
              </template>
              <template v-else>
                  <div class="row justify-content-between">
                      <div class="col-md-6 col-xs-6" >
                          <v-select v-model="item.producto" :options="productosList" placeholder="Selecciona el producto"></v-select>
                      </div>
                      <div class="col-md-4 col-xs-4">
                          <input type="text" @keyup.enter="addCuadro" v-model.number="item.cantidad" placeholder="Cantidad" class="form-control">
                      </div>
                      <div class="col-md-2 col-xs-2">
                          <button @click="addCuadro" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                      </div>
                  </div>
              </template>
              <div class="row" v-if="new_items.length>0">
                  <div class="col-md-12 col-xs-12 mt-4">
                    <table class="table table-condensed ">
                      <thead>
                        <tr>
                          <th>Producto</th>
                          <th>Cantidad</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(item,idx) in new_items" :key="idx+'a'">
                          <td>{{ item.producto.label }}</td>
                          <td>{{ item.cantidad }}</td>
                          <td> <i class="fa fa-times" @click="quitCuadro(idx)"></i> </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
              </div>
          </div>
      </div>
      <div slot="footer">
        <button type="button" class="btn btn-default" @click="closeAbastecer">Cancelar</button>
        <button type="button" class="btn btn-primary" @click="send">Guardar</button>
      </div>
    </bootstrap-modal>
  </div>
</template>
<script>
import axios from "axios";
import ProductoService from '../../services/productos.js';
import {mapGetters,mapActions} from 'vuex';


export default {
  components: {
    "bootstrap-modal": require("vue2-bootstrap-modal")
  },
  data() {
    return {
        params:{
            bodega: null
        },
        productList:[],
        item: { producto:'',cantidad:'',total:0},
        new_items: []
      };
    },
    computed:{
        productosList(){
          this.productList.forEach(x => {
            x.label = x.nombre;
          });
          return this.productList;
        },
        bodegas(){
            let arr = [];
            this.$store.state.bodegas.bodegasFormat.forEach(x => {
                arr.push(x)
            });
            return arr;
        },
    },
    watch:{
      "params.bodega"(){
          this.getProductos(this.params.bodega ? this.params.bodega.id : '')
      }
    },
    created() {
        this.getProductos();
        this.eventHub.$on("openAbastercer", () => {
          this.openAbastercer();
        });
    },
  methods: {
    async getProductos(bodega){
      const rs = await ProductoService.getList({bodega})
      this.productList = rs.data
    },
    send() {
      const e = ProductoService.abastecerProductos(this.new_items);
      this.closeAbastecer();
      this.$noty.success("Abastecer producto con exito");
      this.eventHub.$emit("initProductos");
      this.params.bodega = null
      this.item={};
      this.new_items=[];
    },
    quitCuadro(idx){
        this.new_items.splice(idx, 1)
    },
    addCuadro() {
      if(!Number.isInteger(this.item.cantidad)) return this.$noty.error('Cantidad no válida');
      this.new_items.forEach(e=>{
        if(e.producto.id==this.item.producto.id){
            e.cantidad=e.cantidad+this.item.cantidad
            this.item = { producto: '', cantidad: '',total:0 };
        }

      });
      if(this.item == {producto: '', cantidad: ''}) return false;
      if(this.item.cantidad==0) return this.$noty.error('La cantidad debe ser mayor a 0');
      if(this.item.producto=='') return this.$noty.error('Selecciona un producto');
      this.new_items.push(this.item);
      this.item = { producto: '', cantidad: '' };
    },
    myOpenFunc() {},
    openAbastercer() {
      this.$refs.abastecerModal.open();
    },
    closeAbastecer() {
      this.$refs.abastecerModal.close();
    }
  }
};
</script>
<style>
.title{
  font-size:16px;
}
</style>
