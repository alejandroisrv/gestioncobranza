<template>

  <div>
    <section class="content-header">
      <h1>Inventario</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-right">
              <button class="btn btn-default" @click="openEntregar">
                    <i class="fa fa-truck mr-2"></i>
                    Entregar productos
                  </button>
              <button class="btn btn-default" @click="openAbastercer">Abastecer inventario</button>
              <button class="btn btn-primary" @click="nuevoProducto">
                    <i class="fa fa-plus"></i>
                  </button>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de productos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
              <template v-else>
              <table v-if="productos && productos.length > 0 "
                     id="example1"
                     class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio de contado</th>
                    <th>Precio a credito</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in productos" :key="item.id" >
                    <td>{{ item.nombre }}</td>
                    <td :class="item.cantidad == 0 ? 'text-danger' : ''" >{{item.cantidad}}</td>
                    <td>{{ item.precio_contado}}</td>
                    <td>{{ item.precio_credito }}</td>
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
            </template>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <modal-producto :producto="productoModal"
                      :titulo="tituloModal"
                      :url="urlModal"
                      :notificacion="notificacionModal"></modal-producto>
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

  import { log } from 'util'
  export default {
    data() {
      return {
        productoModal: '',
        productList: [{id:'all', label:'Selecciona un producto'}],
        tituloModal: '',
        urlModal: '',
        notificacionModal: '',
        productoDetalle:{}
      }
    },
    components: {
      modalProducto,
      modalAbastecer,
      modalEntregar,
      producto
    },
    created() {
      this.eventHub.$on('initProductos', ()=>{
        this.initProductos();
      });
      this.initProductos();
    },
    computed: {
     ...mapGetters({
       productos:'productos/productos',
       loading:'productos/loading'
      }),

    },
    methods: {
    ...mapActions({
      initProductos:'productos/initProduct',
    }),
      nuevoProducto() {
        this.openModal()
        this.productoModal = { nombre: '', descripcion: '', precioContado: '', precioCredito: '', precioCosto: '', comision: ''}
        this.tituloModal = 'Nuevo producto'
        this.urlModal = '/api/producto/'
        this.notificacionModal = 'Producto agregado con éxito!'
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
      async eliminarProducto(id) {
      let borrar = await this.$confirm('¿Estas seguro que deseas eliminar el producto?');
        if (borrar) {
          ProductoService.deleteProducto(id);
          this.notificacion('Producto Eliminado')
          this.initProductos();
        }

      },
      notificacion(texto) {
        this.$noty.success(texto)
      },
      openModal() {
        this.eventHub.$emit('openModal')
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
.loading-spinner{font-size: 2.5rem;text-align: center;display: block;margin: 20px 0px;}
</style>
