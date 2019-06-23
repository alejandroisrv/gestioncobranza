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
                <i class="fa fa-plus mr-2"></i> Nuevo Producto
              </button>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de productos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table
                v-if=" productos.length > 0 "
                id="example1"
                class="table table-bordered table-striped"
              >
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th></th>
                    <th>Precio de contado</th>
                    <th>Precio a credito</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in productos" :key="item.id">
                    <td>{{ item.nombre }}</td>
                    <td>{{ item.cantidad}}</td>
                    <td>{{ item.precio_contado}}</td>
                    <td>{{ item.precio_credito }}</td>
                    <td>
                      <button class="btn btn-default btn-sm" @click="verProducto(item)">
                        <i class="fa fa-eye"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div v-else>
                <p class="py-4">No se han encontrado productos</p>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <modal-producto producto="productoModal"></modal-producto>
    </section>
  </div>
</template>
<script>
import modalProducto from "./modalProducto";
export default {
  data() {
    return {
      productoModal: "",
      productList: [],
      tituloModal: "",
      urlModal: "",
      productos: "",
      notificacionModal: ""
    };
  },
  components: {
    modalProducto,
    modalAbastecer,
    modalEntregar
  },
  created() {
    this.getProductos();
    this.eventHub.$on("sendProducto", rs => {
      this.getProductos();
    });
  },
  methods: {
    getProductos() {
      axios.get("/api/productos").then(rs => {
        rs.data.forEach(element => {
          this.productos = rs.data;
          this.productList.push({
            id: element.id,
            nombre: element.nombre,
            cantidad: parseInt(element.cantidad),
            precio_contado: parseInt(element.precio_costo),
            precio_credito: parseInt(element.precio_credito)
          });
        });
      });
    },
    verProducto(producto) {},
    notificacion(texto) {
      this.$noty.success(texto);
    },
    openModal() {
      this.eventHub.$emit("openModal");
    },
  }
};
</script>
