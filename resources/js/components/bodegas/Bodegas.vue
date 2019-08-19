<template>
  <div>
    <section class="content-header">
      <h1>Bodegas</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-right">
              <button class="btn btn-primary" @click="nuevoBodega()">
                <i class="fa fa-plus mr-2"></i> Nueva bodega
              </button>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de bodegas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
              <template v-else>
                <table  v-if="bodegas.data && bodegas.data.length > 0 " class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Sucursal</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Municipio</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in bodegas.data" :key="item.id+'a'">
                    <td>{{ item.sucursal.direccion  }}</td>
                    <td>{{ item.direccion }}</td>
                    <td>{{ item.telefono}}</td>
                    <td v-if="item.municipio != null ">{{ item.municipio.municipio }}</td>
                    <td>
                      <button class="btn btn-primary btn-sm" @click="editarBodega(item)">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-danger btn-sm" @click="eliminarBodega(item.id)">
                        <i class="fa fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div v-else>
                <p class="py-4">No se han encontrado bodegas</p>
              </div>
              </template>


            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
    <modal-bodega :bodega="bodegaModal" :titulo="tituloModal" :url="urlModal" :notificacion="notificacionModal"></modal-bodega>
    </section>
  </div>
</template>
<script>
import modalBodega from "./modalBodegas";
import BodegaService from '../../services/bodegas';
export default {
  data() {
    return {
      bodegaModal: "",
      tituloModal: "",
      urlModal: "",
      bodegas: "",
      notificacionModal: "",
      loading:true
    };
  },
  components: {
    modalBodega
  },
  created() {
    this.getBodegas();
    this.eventHub.$on("sendBodegas", rs => {
      this.getBodegas();
    });
  },
  methods: {
    async getBodegas() {
        this.loading=true;
        const rs = await BodegaService.getAll();
        this.bodegas= rs.data.body;
        this.loading=false;
    },
    nuevoBodega() {

      this.bodegaModal = {
        encargado_id: undefined,
        direccion: "",
        minicipio: undefined,
        telefono: ""
      };
      this.tituloModal = "Nueva bodega";
      this.urlModal = "bodega/";
      this.notificacionModal = "Bodega agregada con éxito!";
      this.openModal();
    },
    editarBodega(bodega) {
      this.bodegaModal = bodega;
      this.tituloModal = "Editar bodega";
      this.urlModal = "bodegas/update/" + bodega.id;
      this.openModal();
      this.notificacionModal = "La bodega ha sido editada!";
    },

    eliminarBodega(id) {
      this.$confirm("¿Estas seguro que deseas eliminar la bodega?").then(
        res => {
          if (res) {
            axios.get(`bodega/delete/${id}`);
            this.getBodegas();
            this.notificacion("Bodega Eliminado");
          }
        }
      );
    },
    notificacion(texto) {
      this.$noty.success(texto);
    },
    openModal() {
      this.eventHub.$emit("openModal");
    }
  }
};
</script>
