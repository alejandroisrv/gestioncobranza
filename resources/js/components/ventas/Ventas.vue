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
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
              <div class="table-responsive" v-else>
                <table v-if="ventas.data && ventas.total > 0" class="table table-bordered table-striped" >
                  <thead>
                    <tr>
                      <th>Vendedor</th>
                      <th>Cliente</th>
                      <th>Tipo de venta</th>
                      <th>Periodo de pago</th>
                      <th>Total</th>
                      <th>Fecha</th>

                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in ventas.data" :key="item.id">
                      <td>{{ item.vendedor.name }}</td>
                      <td>{{item.persona.nombre}}</td>
                      <td>{{ item.tipos_ventas.descripcion }}</td>
                      <td>{{ item.acuerdo_pago.periodo_pago}}</td>
                      <td>{{ item.total | currency}}</td>
                      <td>{{ item.created_at | moment("DD/MM/YYYY") }}</td>
                      <td>
                        <button class="btn btn-default btn-sm" @click="verVenta(item)">
                          <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" role="tooltip" title="Devolucicicion"><i class="fa fa-undo"></i></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-else>
                  <p class="py-4">No se han encontrado ventass</p>
                </div>

              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <modal-venta></modal-venta>
      <venta :venta="ventaDetalle"></venta>
      <devoluciones /> 
    </section>
  </div>
</template>

<script>
import modalVenta from "./modalVentas";
import venta from './Venta';
import { mapActions, mapGetters } from 'vuex';
export default {
  data() {
    return {
      ventaDetalle: ""
    };
  },
  computed:{
    ...mapGetters({
      ventas:'ventas/ventas',
      loading:'ventas/loading',
      tipos:'tipos/tiposVenta'
    }),
  },
  components: {
    modalVenta,
    venta,
    "bootstrap-modal": require("vue2-bootstrap-modal")
  },
  created() {
    this.initVentas();
    this.eventHub.$on("sendVentas", rs => {
      this.initVentas();
    });
  },
  methods: {
    ...mapActions({
      initVentas:'ventas/initVentas'
    }),
    nuevaVenta() {
      this.openModal();
    },
    verVenta(venta) {
      this.openVenta(venta);
    },
    openModal() {
      this.eventHub.$emit("openModal");
    },
    openVenta(venta) {
      this.eventHub.$emit('openDetalle',venta);
    },
  }
};
</script>
