<template>
  <div>
    <section class="content-header">
      <h1>Clientes</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-right">
              <button class="btn btn-primary" @click="nuevoCliente">
                <i class="fa fa-plus mr-2"></i> Nuevo cliente
              </button>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de Clientes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
              <template v-else>
                <table v-if=" clientes.data && clientes.data.length > 0 " class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Direccion</th>
                      <th>Telefono</th>
                      <th>E-mail</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in clientes.data" :key="item.id">
                      <td>{{ item.nombre }}</td>
                      <td>{{ item.direccion }}</td>
                      <td>{{ item.telefono}}</td>
                      <td>{{ item.email }}</td>
                      <td>
                        <button class="btn btn-default btn-sm" @click="verCliente(item)">
                          <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-primary btn-sm" @click="editarCliente(item)">
                          <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" @click="eliminarCliente(item.id)">
                          <i class="fa fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-else>
                  <p class="py-4">No se han encontrado clientes</p>
                </div>
              </template>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <modal-cliente :cliente="clienteModal" :titulo="tituloModal" :url="urlModal" :notificacion="notificacionModal"></modal-cliente>
      <cliente></cliente>
    </section>
  </div>
</template>
<script>
import modalCliente from "./modalCliente";
import cliente from "./Cliente";
import { log } from "util";
export default {
  data() {
    return {
      clienteModal: "",
      tituloModal: "",
      urlModal: "",
      clientes: "",
      notificacionModal: ""
    };
  },
  components: {
    modalCliente,cliente
  },
  created() {
    this.getClientes();
    this.eventHub.$on("sendCliente", rs => {
      this.getClientes();
    });
  },
  methods: {
    getClientes() {
      axios.get("/api/clientes").then(rs => {
          this.clientes = rs.data.body;
        }).catch(err => {
          this.$noty.error("Ha ocurrido un error al intentar agregar al cliente "+err.response.data.message);
        });
    },
    nuevoCliente() {
      this.openModal();
      this.clienteModal = {
        nombre: "",
        apellido: "",
        direccion: "",
        cedula: "",
        minicipio: "",
        telefono: "",
        email: ""
      };
      this.tituloModal = "Nuevo cliente";
      this.urlModal = "/api/cliente/add";
      this.notificacionModal = "Cliente agregado con exito agregado con éxito!";
    },

    
    editarCliente(cliente) {
      this.clienteModal = cliente;
      this.tituloModal = "Editar cliente";
      this.urlModal = "/api/clientes/update/" + cliente.id;
      this.openModal();
      this.notificacionModal = "El cliente ha sido editado!";
    },
    verCliente(cliente) {
      this.eventHub.$emit('verCliente',cliente);
    },
    eliminarCliente(id) {
      this.$confirm("¿Estas seguro que deseas eliminar el cliente?").then(
        res => {
          if (res) {
            axios.get(`/api/cliente/delete/${id}`);
            this.getClientes();
            this.notificacion("Cliente Eliminado");
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

