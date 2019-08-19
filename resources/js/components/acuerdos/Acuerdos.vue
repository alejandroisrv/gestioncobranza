<template>

  <div>
    <section class="content-header">
      <h1>Nómina</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-right">
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de trabajadores</h3>
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
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Dirección</th>
                    <th>Rol</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in nomina" :key="item.id" >
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

    </section>
  </div>

</template>
<script>
export default{

  data(){
    return {


    }

  },
  created(){


  }
}
</script>
