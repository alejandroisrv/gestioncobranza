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
              <table
                v-if=" clientes.length > 0 "
                id="example1"
                class="table table-bordered table-striped"
              >
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>E-mail</th>
                    <th>Deuda</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in clientes" :key="item.id">
                    <td>{{ item.nombre }}</td>
                    <td>{{ item.direccion }}</td>
                    <td>{{ item.telefono}}</td>
                    <td>{{ item.deuda }}</td>
                    <td>
                      <button class="btn btn-default btn-sm" @click="verCliente(item)">
                        <i class="fa fa-eye"></i>
                      </button>
                      <button class="btn btn-danger btn-sm" @click="suspenderCliente(item.id)">
                        <i class="fa fa-ban"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div v-else>
                <p class="py-4">No se han encontrado clientes</p>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <modal-cliente></modal-cliente>
    </section>
  </div>
</template>
<script>
import modalCliente from "./modalCliente";
import {mapGetters, mapActions } from 'vuex';
export default {
  data() {
    return {
      clienteModal: "",
      notificacionModal: ""
    };
  },
  components: {
    modalCliente
  },
  computed:{
      ...mapGetters({
          clientes:'clientes/clientes',
          clientesFormat:'clientes/clientesFormat'
      }),
  },
  created() {
    this.initClientes();
    this.eventHub.$on("sendCliente", rs => {
      this.initClientes();
    });
  },
  methods: {
      ...mapActions({
          initClientes:'clientes/initClientes',
      }),
    verCliente(cliente) {
        this.clienteModal=cliente;
        this.openModal();
    },
    suspenderCliente(id) {
      this.$confirm("¿Estas seguro que deseas suspender este cliente?").then(
        res => {
          if (res) {
            axios.get(`/api/cliente/suspender/${id}`);
            this.getClientes();
            this.notificacion("Cliente suspendido");
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
