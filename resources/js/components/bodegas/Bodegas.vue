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
              <button class="btn btn-primary" @click="nuevoBodega">
                <i class="fa fa-plus mr-2"></i> Nuevo bodega
              </button>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de bodegas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table
                v-if=" bodegas.length > 0 "
                id="example1"
                class="table table-bordered table-striped"
              >
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
                  <tr v-for="item in bodegas" :key="item.id">
                    <td>{{ item.sucursal.direccion  }}</td>
                    <td>{{ item.direccion }}</td>
                    <td>{{ item.telefono}}</td>
                    <td>{{ item.municipio }}</td>
                    <td>
                      <button class="btn btn-default btn-sm" @click="verBodega(item)">
                        <i class="fa fa-eye"></i>
                      </button>
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
                <p class="py-4">No se han encontrado bodegass</p>
              </div>
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
import { log } from "util";
export default {
  data() {
    return {
      bodegaModal: "",
      tituloModal: "",
      urlModal: "",
      bodegas: "",
      notificacionModal: ""
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
        const rs = await BodegaService.getAll();
        this.bodegas= rs.data.data;
    },
    nuevoBodega() {
      this.openModal();
      this.bodegaModal = {
        encargado_id: "",
        direccion: "",
        minicipio: "",
        telefono: ""
      };
      this.tituloModal = "Nueva bodega";
      this.urlModal = "/api/bodega/";
      this.notificacionModal = "Bodega agregada con éxito!";
    },
    editarBodega(bodega) {
      this.bodegaModal = bodega;
      this.tituloModal = "Editar bodega";
      this.urlModal = "/api/bodegas/update/" + bodega.id;
      this.openModal();
      this.notificacionModal = "La bodega ha sido editada!";
    },
    verBodega(bodega) {},
    eliminarBodega(id) {
      this.$confirm("¿Estas seguro que deseas eliminar la bodega?").then(
        res => {
          if (res) {
            axios.get(`/api/bodega/delete/${id}`);
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
