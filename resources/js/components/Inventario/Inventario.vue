<template>

  <div>
    <section class="content-header">
      <h1>Inventario</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body justify-content-end">
              <div class="row justify-content-end" style="line-height:34px;">
                <div class="col-md-1" v-if="$isAdmin" style="padding-left:20px;">Bodega:</div>
                <div class="col-md-3 p-0" v-if="$isAdmin"><v-select v-model="bodega" :options="bodegas" placeholder="Selecciona la bodega" /></div>
                <div class="col-md-8 text-right">
                  <button class="btn btn-default mx-1" @click="openEntregar"> <i class="fa fa-truck mr-2"></i>Entregar productos</button>
                  <button class="btn btn-default mx-1" @click="openAbastercer">Abastecer inventario</button>
                  <button class="btn btn-primary mx-1" @click="nuevoProducto"><i class="fa fa-plus"></i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de productos</h3>
              <div class="box-tools">
                <div class="input-group input-group-sm hidden-xs" style="width: 250px;margin:5px;">
                  <input v-model="buscar" @keyup.enter="searchProductos" class="form-control input-buscar" placeholder="Buscar...">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default input-buscar"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
              <template v-else>
                <div class="table-responsive">
                  <table v-if="productos.data && productos.data.length > 0 " class="col-md-12 table table-bordered table-striped align-items-center align-selfs-center align-center">
                    <thead>
                      <tr>
                        <th>Imágen</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Categoria</th>
                        <th>Stock</th>
                        <th>Precio de costo</th>
                        <th>Precio a credito</th>
                        <th>Agregado</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in productos.data" :key="item.id">
                        <td class="text-center"><img :src="item.imagen ? 'img/productos/'+ item.imagen : 'img/imgnofound.png' "  class="img-producto" /></td>
                        <td> <b> {{ item.cod }}</b></td>
                        <td> {{ item.descripcion }} </td>
                        <td> {{ item.tipo.label }} </td>
                        <td class="text-center"><span v-if="item.cantidad > 15 " class="label stock label-success"> {{item.cantidad}}</span> <span v-else-if="item.cantidad < 5" class="label stock label-danger">{{item.cantidad}}</span> <span v-else-if="item.cantidad > 5 && item.cantidad < 15 " class="label stock label-warning">{{item.cantidad}}</span> </td>
                        <td>{{ item.precio_costo | currency }}</td>
                        <td>{{ item.precio_credito | currency  }}</td>
                        <td> {{ item.created_at | moment('DD/MM/YYYY h:m a') }}</td>
                        <td>
                          <button class="btn btn-default btn-sm" @click="verProducto(item)">
                                <i class="fa fa-eye"></i>
                          </button>
                          <button class="btn btn-primary btn-sm" @click="editarProducto(item)">
                                <i class="fa fa-edit"></i>
                          </button>
                          <button class="btn btn-danger btn-sm" @click="eliminarProducto(item.id)">
                                <i class="fa fa-trash"></i>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div v-else>
                    <p class="py-4">No se han encontrado productos</p>
                  </div>
                </div>
                <div class="box-footer clearfix">
                    <pagination :data="productos" @pagination-change-page="searchProductos"></pagination>
                </div>

            </template>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <modal-producto :titulo="tituloModal" :url="urlModal" :notificacion="notificacionModal"></modal-producto>
      <modal-entregar></modal-entregar>
      <modal-abastecer :productoList="productList"></modal-abastecer>
      <producto :producto="productoDetalle"></producto>
      <div></div>
    </section>
  </div>

</template>
<script>

import modalProducto from './modalProducto'
import modalAbastecer from './modalAbastecer'
import modalEntregar from './modalEntregar'
import producto from './producto'
import ProductoService from '../../services/productos.js'
import {mapGetters, mapActions} from 'vuex';
import Noty from 'noty'
  export default {
    data() {
      return {
        productoModal: '',
        productList: [{id:'all', label:'Selecciona un producto'}],
        tituloModal: '',
        urlModal: '',
        notificacionModal: '',
        productoDetalle:{},
        loading:true,
        productos:[],
        buscar:'',
        bodega:'Todas'
        
      }
    },
    computed:{
        bodegas(){
          let arr = [{id:'all',label:'Todas'}];
          this.$store.state.bodegas.bodegasFormat.forEach(x => {
             arr.push(x)
           });
           return arr;
        },

    },
    watch:{
      "bodega"(){
        this.searchProductos();
      }
    },
    components: { modalProducto, modalAbastecer, modalEntregar, producto },
    created() {
      this.eventHub.$on('initProductos', ()=>{
        this.searchProductos();
      });
      this.searchProductos();
      this.getProductoFormat();
    },
    methods: {
      ...mapActions({getProductoFormat:'productos/getProductoFormat'}),
      async searchProductos(page = 1){
        let bodega = (this.bodega.id) ? this.bodega.id :'';
        let parametros = { bodega:bodega, buscar:this.buscar,page:page}
        this.loading = true;
        const rs = await ProductoService.getAll(parametros);
        this.productos = rs.data;
        this.loading = false;
      },
      nuevoProducto() {
        this.productoModal = { nombre: '', descripcion: '', precioContado: '', precioCredito: '', precioCosto: '', comision: '', tipo : undefined,imagen:''}
        this.tituloModal = 'Nuevo producto'
        this.urlModal = '/api/producto/add'
        this.notificacionModal = 'Producto agregado con éxito!'
        this.openModal()
      },
      editarProducto(producto) {
        this.productoModal = producto
        this.tituloModal = 'Editar producto'
        this.urlModal = '/api/producto/update/' + producto.id
        this.openModal()
        this.notificacionModal = 'El producto ha sido editado!'
      },
      verProducto(producto) {
        this.productoDetalle=producto;
        this.eventHub.$emit('detalleProducto')

      },
      eliminarProducto(id) {
        var n = new Noty({
          text: '¿Estas seguro que deseas eliminar el producto?',
          layout:'center',
          modal:true,
          buttons: [
               Noty.button('Cancelar', 'btn btn-danger mx-2 btn-sm', function () {
                n.close();
            }),
            Noty.button('Aceptar', 'btn-sm btn btn-primary', function () {
                ProductoService.deleteProducto(id).then(rs=>{
                  this.notificacion('Producto Eliminado')
                  this.searchProductos(1);
                }).catch(err=>{
                  this.$noty.error("No se ha podido eliminar el producto");
                })
                n.close();
            }.bind(this), {id: 'button1', 'data-status': 'ok'})
          ]
        });
        n.show();
      },
      notificacion(texto) {
        this.$noty.success(texto)
      },
      openModal() {
        this.eventHub.$emit('openModal',this.productoModal);
      },
      openAbastercer() {
        this.eventHub.$emit('openAbastercer')
      },
      openEntregar() {
        this.eventHub.$emit('openEntregar')
      }
    }
  }

</script>
<style>

.stock{font-size:14px!important;}
.img-producto{ width:70px; height:60px;  }
.noty_buttons{ text-align:center;}
.select2-container--default .select2-selection--single{
  border-radius: 0px !important;
}

</style>
