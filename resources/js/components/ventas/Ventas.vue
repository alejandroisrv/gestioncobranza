<template>
  <div>
    <section class="content-header">
      <h1>Ventas</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-right">
              <button class="btn btn-primary" @click="nuevaVenta">
                <i class="fa fa-plus mr-2"></i> Nuevo venta
              </button>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">
                Listado de ventas
                <b v-if="tipo!=''">de {{ tipo }}</b>
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table
                v-if="ventas.length>0"
                id="example1"
                class="table table-bordered table-striped"
              >
                <thead>
                  <tr>
                    <th>Vendedor</th>
                    <th>Cliente</th>
                    <th>Tipo de venta</th>
                    <th>Perido de pago</th>
                    <th>Total</th>
                    <th>Fecha</th>

                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in ventas" :key="item.id">
                    <td>{{ item.vendedor.name }}</td>
                    <td>{{item.persona.nombre}}</td>
                    <td>{{ item.tipos_ventas.descripcion }}</td>
                    <td>{{ item.acuerdo_pago.periodo_pago}}</td>
                    <td>{{item.total}}</td>
                    <td>{{ item.created_at }}</td>
                    <td>
                      <button class="btn btn-default btn-sm" @click="verVenta(item)">
                        <i class="fa fa-eye"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div v-else>
                <p class="py-4">No se han encontrado ventass</p>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <modal-venta></modal-venta>
    </section>
  </div>
</template>

<script>
import modalVenta from "./modalVentas";
import { log } from "util";
export default {
  data() {
    return {
      urlModal: "",
      ventas: "",
      clientes: "",
      productos: [],
      tipo: "",
      venta: ""
    };
  },
  components: {
    modalVenta,
    "bootstrap-modal": require("vue2-bootstrap-modal")
  },
  created() {
    this.getVentas();
    this.eventHub.$on("sendVentas", rs => {
      this.getVentas();
    });
  },
  methods: {
    getVentas() {
      axios.get("/api/ventas").then(rs => {
        this.ventas = rs.data;
      });
    },

    nuevaVenta() {
      this.openModal();
    },
    verVenta(venta) {
      this.modalVenta = venta;
      this.openVenta();
    },
    notificacion(texto) {
      this.$noty.success(texto);
    },
    openModal() {
      this.eventHub.$emit("openModal");
    },
    openVenta() {
      this.$refs.ventaDetalle.open();
    },
    closeTheModalVenta() {
      this.$refs.ventaDetalle.close();
    }
  }
};
</script>
