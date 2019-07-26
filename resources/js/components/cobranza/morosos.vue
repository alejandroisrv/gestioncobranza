<template>
  <div>
    <section class="content-header">
      <h1>Inventario</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-left align-self-center">
              <div class="col-md-2">Filtrar por municipios</div>
              <div class="col-md-4">
                <v-select v-model="municipio" :options="municipiosFormat" placeholder="Selecciona el municipio" />
              </div>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de Clientes en mora</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table v-if="clientes.data.length > 0 " class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Deuda</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in clientes.data" :key="item.id">
                    <td>{{ item.nombre }}</td>
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
      <modal-cliente :cliente="clienteModal"></modal-cliente>
    </section>
  </div>
</template>
<script>
import modalCliente from "../clientes/Cliente";
import { mapGetters, mapActions } from "vuex";
import { log } from "util";

export default {
  data() {
    return {
      clienteModal: "",
      notificacionModal: "",
      municipio: ""
    };
  },
  components: {
    modalCliente
  },
  computed: {
    ...mapGetters({
      clientes: "clientes/clientes",
      clientesFormat: "clientes/clientesFormat",
      municipiosFormat: "municipios/municipiosFormat"
    })
  },
  created() {
    this.initClientes();
    this.eventHub.$on("sendCliente", rs => {
      this.initClientes();
    });
  },
  methods: {
    ...mapActions({
      initClientes: "clientes/initClientes"
    }),
    getMorosos(){

      

    },
    verCliente(cliente) {
      this.clienteModal = cliente;
      this.openModal();
    },
    suspenderCliente(id) {
      this.$confirm("¿Estas seguro que deseas suspender este cliente?").then(
        res => {
          if (res) {
            const rs = ClienteService.suspend(id);
            if (rs) this.notificacion("Cliente suspendido");
            else this.$noty.error("Error al intentar suspender cliente");
          }
        }
      );
    },
    notificacion(texto) {
      this.$noty.success(texto);
    },
    openModal() {
      this.eventHub.$emit("detalleCliente");
    }
  }
};
</script>
