<template>
    <bootstrap-modal ref="filtrosCobro" :need-header="false" :need-footer="false" :size="'small'">
      <div slot="body">
          <div class="box">
              <div class="box-header">
                  <p style="font-size:18px">Selecciona el filtro</p>
              </div>
              <div class="box-body">
                  <div class="row">
                      <div class="col-md-12">
                          <table>
                              <tr>
                                  <td>Cliente</td>
                                  <td><v-select v-model="ruta.cliente" :options="clientes" placeholder="Selecciona un cliente"></v-select></td>
                              </tr>
                              <tr>
                                  <td>Cobrador</td>
                                  <td><v-select v-model="ruta.cobrador" :options="cobradores" placeholder="Selecciona el municipio"></v-select></td>
                              </tr>
                              <tr>
                                  <td>Municipio</td>
                                  <td><v-select v-model="ruta.municipio" :options="municipios" placeholder="Selecciona el municipio"></v-select></td>
                              </tr>
                              <tr>
                                  <td>Ruta</td>
                                  <td><v-select v-model="filtro.ruta" :options="rutas" placeholder="Selecciona el municipio"></v-select></td>
                              </tr>
                              <tr>
                                  <td>Desde</td>
                                  <td><datepicker v-model="state.desde"></datepicker></td>
                                  <td>Hasta</td>
                                  <td><datepicker v-model="filtro.hasta"></datepicker></td>
                              </tr>
                          </table>

                      </div>
                  </div>
              </div>
          </div>
      </div>
    </bootstrap-modal>

</template>
<script>
import RutaService from '../../services/rutas';
import { mapActions, mapGetters } from 'vuex';

export default {
    
    data(){
        return{
            filtro:{
                cliente:{},
                cobrador:{},
                municipio:{},
                ruta:{},
                desde:new Date(),
                hasta: new Date()
            }
        }
    },
    computed:{
        ...mapGetters({
            clientes:'clientes/clientesFormat',
            municipios:'municipios/municipiosFormat',
            cobradores:'users/usersFormat',
            rutas:'rutas/rutasFormat'
        }),
    },
    components:{
        "bootstrap-modal": require("vue2-bootstrap-modal")
    },
    created(){

        this.eventHub.$on('openFiltrar', ()=>{
            this.$refs.filtrosCobro.open();
        });

    },
    watch:{

    },
    methods:{
        ...mapActions({
            getCobradores:'users/getUsersFormat',
            getClientes:'clientes/getClientesFormat',
            getRutas:'rutas/getRutasFormat'
        }),
        getData(){
            this.getCobradores();
            this.getClientes();
            this.getRutas();
        },
        filtrar(){
            this.eventHub.$emit('filtrar', this.filtro);
            this.$refs.filtrosCobro.close();
        }
    }

}
</script>
