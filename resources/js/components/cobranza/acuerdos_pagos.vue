
<template>
  <div>
    <section class="content-header">
      <h1>Acuerdos de</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-right">
              <button class="btn btn-primary" @click="nuevoAcuerdo">
                <i class="fa fa-plus mr-2"></i> Registrar nuevo pago
              </button>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de Clientes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table v-if=" clientes.data && acuerdo_pagos.data.length > 0 " class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Venta</th>
                    <th>Cliente</th>
                    <th>Cuotas</th>
                    <th>Periodo de pago</th>
                    <th>Monto</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in acuerdo_pagos.data" :key="item.id">
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
                <p class="py-4">No se han encontrado acuerdo_pagos</p>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <modal-acuerdo :acuerdo="acuerdo"></modal-acuerdo>
      <cliente></cliente>
    </section>
  </div>
</template>
<script>
import modalAcuerdo from "./modalAcuerdo";
import acuerdo from "./acuerdo";
import { log } from "util";
export default {
  data() {
    return {
      nuevo_acuerdo:{ nombre: "",
        apellido: "",
        direccion: "",
        cedula: "",
        minicipio: "",
        telefono: "",
        email: ""
      },
      acuerdo:{}
    };
  },
  components: {
    modalAcuerdoPago,acuerdo
  },
  created() {
    this.getAcuerdos();
    this.eventHub.$on("sendCliente", rs => {
      this.getClientes();
    });
  },
  methods: {
    getClientes() {
      axios.get("/api/acuerdo_pagos").then(rs => {
          this.acuerdo_pagos = rs.data.body;
        }).catch(err => {
          this.$noty.error("Ha ocurrido un error al intentar agregar al cliente "+err.response.data.message);
        });
    },
    nuevoCliente() {
      this.openModal();
      this.tituloModal = "Nuevo Acuerdo de pago ";
      this.urlModal = "/api/cliente/add";
      this.notificacionModal = "Cliente agregado con exito agregado con éxito!";
    },

    verCliente(cliente) {
      this.eventHub.$emit('verCliente',cliente);
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

