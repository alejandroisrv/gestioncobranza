<template>
  <div>
    <section class="content-header">
      <h1>Tipos de productos</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-left justify-content-end align-items-center">
              <div class="col-md-12 text-right">
                <button class="btn btn-primary" @click="addTipo()"><i class="fa fa-plus"></i> Nuevo tipo </button>
              </div>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
              <div class="table-responsive" v-else>
                <table v-if="tipos.data && tipos.data.length > 0 " class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>id</th>
                      <th>Descripción</th>
                      <th>Productos enlazados</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in tipos.data" :key="item.id">
                      <td>{{ item.id }}</td>
                      <td>{{ item.label }}</td>
                      <td>{{ item.productos_count }}</td>
                      <td>
                         <button class="btn btn-primary btn-sm" @click="editarTipo(item)">
                              <i class="fa fa-edit"></i>
                          </button>
                          <button class="btn btn-danger btn-sm" @click="eliminarTipo(item.id)" v-if="item.productos_count == 0">
                                <i class="fa fa-trash"></i>
                          </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-else>
                  <p class="py-4">No se han creado tipos de productos</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <nuevo-tipo />
  </div>
</template>
<script>
import ProductoService from '../../services/productos';
import NuevoTipo from './ModalTipo';
export default {
  data() {
    return {
      loading:true,
      tipos: "",
    }
  },
  components: { NuevoTipo },
  created() {
    this.getTipos();
    this.eventHub.$on("LoadTipos",() => this.getTipos());
  },
  methods: {
    async getTipos(){
      this.loading = true;
      const rs = await ProductoService.getTipos();
      this.tipos = rs.data.body;
      this.loading = false;
    },
    addTipo(){
      this.eventHub.$emit('NuevoTipo',null);
    },
    editarTipo(item){
      this.eventHub.$emit('NuevoTipo',item);
    },  
    eliminarTipo(id){
      var n = new Noty({
      text: '¿Estas seguro que deseas eliminar el producto?',
      layout:'center',
      modal:true,
      buttons: [
            Noty.button('Cancelar', 'btn btn-danger mx-2 btn-sm', function () {
            n.close();
        }),
        Noty.button('Aceptar', 'btn-sm btn btn-primary', function () {
            ProductoService.deleteTipos(id);
            this.$noty.success('Tipo de producto eliminado');
            this.getTipos();
            n.close();
          }.bind(this), {id: 'button1', 'data-status': 'ok'})
        ]
      });
      n.show();
    }
  }
};
</script>
