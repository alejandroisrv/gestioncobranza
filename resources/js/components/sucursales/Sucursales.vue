<template>
  <div>
    <section class="content-header">
      <h1>Sucursales</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-right">
              <button class="btn btn-primary" @click="nuevoSucursal">
                <i class="fa fa-plus mr-2"></i> Nuevo Sucursal
              </button>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de Sucursales</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
              <template v-else>
                <table v-if=" sucursales.data && sucursales.data.length > 0 " class="table table-bordered table-striped" >
                  <thead>
                    <tr>
                      <th>Dirección</th>
                      <th>Telefono</th>
                      <th>Municipio</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in sucursales.data" :key="item.id+'a'">
                      <td>{{ item.direccion }}</td>
                      <td>{{ item.telefono}}</td>
                      <td v-if="item.municipio">{{ item.municipio.municipio }}</td>
                      <td>
                        <button class="btn btn-primary btn-sm" @click="editarSucursal(item)">
                          <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" @click="eliminarSucursal(item.id)">
                          <i class="fa fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-else>
                  <p class="py-4">No se han encontrado sucursaless</p>
                </div>
              </template>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <modal-sucursal :sucursal="sucursalModal" :titulo="tituloModal" :url="urlModal" :notificacion="notificacionModal"></modal-sucursal>
    </section>
  </div>
</template>
<script>
import modalSucursal from "./modalSucursal";
import { log } from "util";
export default {
  data() {
    return {
      loading:true,
      sucursalModal: "",
      tituloModal: "",
      urlModal: "",
      sucursales: "",
      notificacionModal: ""
    };
  },
  components: {
    modalSucursal
  },
  created() {
    this.getSucursales();
    this.eventHub.$on("sendSucursal", rs => {
      this.getSucursales();
    });
  },
  methods: {
    getSucursales() {
      axios.get("/api/sucursales").then(rs => {
          this.sucursales = rs.data.body;
        }).catch(err => {
          console.log(err);
        }).finally(fl=>{
          this.loading = false;
        });
    },
    nuevoSucursal() {
      this.openModal({encargado: "",direccion: "", minicipio: "",telefono: ""});
      this.tituloModal = "Nueva sucursal";
      this.urlModal = "/api/sucursal/";
      this.notificacionModal = "Sucursal agregada con éxito!";
    },
    editarSucursal(sucursal) {
      this.sucursalModal = sucursal;
      this.tituloModal = "Editar sucursal";
      this.urlModal = "/api/sucursales/update/" + sucursal.id;
      this.openModal(sucursal);
      this.notificacionModal = "La sucursal ha sido editada!";
    },
    verSucursal(sucursal) {},
    eliminarSucursal(id) {
      var n = new Noty({
      text: '¿Estas seguro que deseas eliminar la sucursal?',
      layout:'center',
      modal:true,
      buttons: [
        Noty.button('Cancelar', 'btn btn-danger mx-2 btn-sm', function () {
            n.close();
        }),
        Noty.button('Aceptar', 'btn-sm btn btn-primary', function () {
            axios.get(`/api/sucursal/delete/${id}`).then(rs =>{
              this.getSucursales();
              this.notificacion("Sucursal Eliminado");
            }).catch(err => this.$noty.error('Se ha producido un error al intentar eliminar la sucursal'));
            n.close();
        }.bind(this), {id: 'button1', 'data-status': 'ok'})
        ]
      });
      n.show();
    },
    notificacion(texto) {
      this.$noty.success(texto);
    },
    openModal(sucursal) {
      this.eventHub.$emit("openModal",sucursal);
    }
  }
};
</script>
