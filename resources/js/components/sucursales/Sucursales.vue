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
              <button class="btn btn-primary" @click="nuevoSucursal">
                <i class="fa fa-plus mr-2"></i> Nuevo Sucursal
              </button>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de Sucursals</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table
                v-if=" sucursales.length > 0 "
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
                  <tr v-for="item in sucursales" :key="item.id">
                    <td>{{    }}</td>
                    <td>{{ item.direccion }}</td>
                    <td>{{ item.telefono}}</td>
                    <td>{{ item.municipio }}</td>
                    <td>
                      <button class="btn btn-default btn-sm" @click="verSucursal(item)">
                        <i class="fa fa-eye"></i>
                      </button>
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
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <modal-sucursal
        :sucursal="sucursalModal"
        :titulo="tituloModal"
        :url="urlModal"
        :notificacion="notificacionModal"
      ></modal-sucursal>
    </section>
  </div>
</template>
<script>
import modalSucursal from "./modalSucursal";
import { log } from "util";
export default {
  data() {
    return {
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
      axios
        .get("/api/sucursales")
        .then(rs => {
          this.sucursales = rs.data;
          console.log(rs);
        })
        .catch(err => {
          console.log(err);
        });
    },
    nuevoSucursal() {
      this.openModal();
      this.sucursalModal = {
        encargado: "",
        direccion: "",
        minicipio: "",
        telefono: ""
      };
      this.tituloModal = "Nueva sucursal";
      this.urlModal = "/api/sucursal/";
      this.notificacionModal = "Sucursal agregada con éxito!";
    },
    editarSucursal(sucursal) {
      this.sucursalModal = sucursal;
      this.tituloModal = "Editar sucursal";
      this.urlModal = "/api/sucursales/update/" + sucursal.id;
      this.openModal();
      this.notificacionModal = "La sucursal ha sido editada!";
    },
    verSucursal(sucursal) {},
    eliminarSucursal(id) {
      this.$confirm("¿Estas seguro que deseas eliminar la sucursal?").then(
        res => {
          if (res) {
            axios.get(`/api/sucursal/delete/${id}`);
            this.getSucursales();
            this.notificacion("Sucursal Eliminado");
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
