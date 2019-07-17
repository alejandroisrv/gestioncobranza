<template>
  <div>
    <section class="content-header">
      <h1>Cobros</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-left justify-content-end align-items-center">
              <div class="col-md-12 text-right">
                <span @click="showFiltros()" class="mx-4">Filtrar cobros</span>
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
              <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
              <div class="table-responsive" v-else>
                <table v-if="cobros.data && cobros.data.length > 0 " class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Cobrador</th>
                      <th>Ruta</th>
                      <th>Estado </th>
                      <th>Fecha</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in cobros.data" :key="item.id">
                      <td>{{ item.cobrador.name }}</td>
                      <td>{{ item.ruta.nombre }}</td>
                      <td v-if="item.estado==0">  <span class="label label-primary">{{ item.estado | cobrosEstado(item.estado ) }}</span> </td>
                        <td v-if="item.estado==1"><span class="label label-warning">{{ item.estado | cobrosEstado(item.estado ) }}</span> </td>
                        <td v-if="item.estado==2"><span class="label label-success">{{ item.estado | cobrosEstado(item.estado ) }}</span> </td>
                      <td>{{ item.created_at | moment('DD/MM/YYYY') }}</td>
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
      </div>
      <cobro />

      <filtros />
      <nuevo-cobro />
    </section>
  </div>
</template>
<script>
import CobroService from '../../services/cobros'
import Cobro from "./Cobro";
import NuevoCobro from "./AddCobros";
import Filtros from './FiltrosCobros'

import { mapGetters, mapActions } from "vuex";


export default {
  data() {
    return {
      clienteModal: "",
      cobros:[{data:{}}]
    };
  },
  components: { NuevoCobro ,Cobro, Filtros },
  computed: {
    ...mapGetters({
        clientes: "clientes/clientesFormat",
        cobros:'cobros/cobros',
        loading:'cobros/loading'
    })
  },
  created() {
    this.getCobros({});
  },
  methods: {  
    ...mapActions({getCobros:'cobros/getCobrosAll'}),
    nuevaJornada(){
      this.eventHub.$emit('nuevaJornada');
    },
    verCobro(item) {
      this.eventHub.$emit('verCobro',item);
    },
    showFiltros(){
        this.eventHub.$emit('openFiltrar');
    },
  }
};
</script>
