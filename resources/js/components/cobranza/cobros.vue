<template>
  <div>
    <section class="content-header">
      <h1>Cobros</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-left align-items-center">
              <div class="col-md-4">
                <span @click="showFiltros()">Filtrar cobros</span>
                <button class="btn btn-primary" @click="nuevaJornada()">Nueva jornada de cobranza</button>
              </div>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de cobros</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table v-if="cobros.data && cobros.data.length > 0 " class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Cobrador</th>
                    <th>Ruta</th>
                    <th>Estado </th>
                    <th>Fecha </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in cobros.data" :key="item.id">
                    <td>{{ item.cobrador.nombre }} {{ item.cobrador.apellido }}</td>
                    <td>{{ item.ruta.nombre }}</td>
                    <td>{{ item.estado }}</td>
                    <td>{{ item.created_at }}</td>
                    <td>
                      <button class="btn btn-default btn-sm" @click="verCobro(item)">
                        <i class="fa fa-eye"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div v-else>
                <p class="py-4">No se han encontrado cobros</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <cobro />
      <add-cobro />
      <filtros />
    </section>
  </div>
</template>
<script>
import CobroService from '../../services/cobros'
import Cobro from "./Cobro";
import AddCobros from "./AddCobros";
import Filtros from './FiltrosCobros'

import { mapGetters, mapActions } from "vuex";


export default {
  data() {
    return {
      clienteModal: "",
    };
  },
  components: {
    AddCobros,Cobro,Filtros
  },
  computed: {
    ...mapGetters({
      clientes: "clientes/clientesFormat",
    })
  },
  created() {
    this.getCobros({});
    this.getClientes();
    this.eventHub.$on("filtrar", query => {
      this.getCobros(query);
    });
  },
  methods: {
    ...mapGetters({getClientes:'clientes/'}),
    nuevaJornada(){
      this.eventHub.$emit('nuevaJornada');
    },
    verCobro(item) {
      this.eventHub.$emit('verCobro',item);
    },
    showFiltros(){
        this.eventHub.$emit('openFiltrar');
    },
    async getCobros(query){
      const rs = await CobroService.getAll(query);
      this.cobros = rs.data.body;
      this.datos_buscados = rs.data.datos_buscados;
    },
  }
};
</script>
