<template>
    <bootstrap-modal ref="filtrosCobro" :need-header="false" :need-footer="false" :size="'small'">
      <div slot="body">
          <div class="box">
                  <div class="row">
                      <div class="col-md-12" v-if="loading">
                          <p style="font-size:18px">Selecciona el filtro</p>
                          <table class="table col-md-12">
                              <tr>
                                  <td class="td-label">Cliente:</td>
                                  <td class="td-select"><v-select v-model="filtro.ruta.cliente" :options="clientes" placeholder="Selecciona un cliente"></v-select></td>
                              </tr>
                              <tr>
                                  <td class="td-label">Cobrador:</td>
                                  <td class="td-select"><v-select v-model="filtro.ruta.cobrador" :options="cobradores" placeholder="Selecciona el municipio"></v-select></td>
                              </tr>
                              <tr>
                                  <td class="td-label">Municipio:</td>
                                  <td class="td-select"><v-select v-model="filtro.ruta.municipio" :options="municipios" placeholder="Selecciona el municipio"></v-select></td>
                              </tr>
                              <tr>
                                  <td class="td-label">Ruta:</td>
                                  <td class="td-selct"><v-select v-model="filtro.ruta" :options="rutas" placeholder="Selecciona el municipio"></v-select></td>
                              </tr>
                              <tr>
                                  <td class="td-label-sm">Desde</td>
                                  <td class="td-select-sm"><datepicker></datepicker></td>
                                  <td class="td-label-sm">Hasta</td>
                                  <td class="td-select-sm"><datepicker></datepicker></td>
                              </tr>
                          </table>
                    </div>
              </div>
          </div>
      </div>
    </bootstrap-modal>

</template>
<script>
import datepicker from 'vuejs-datepicker';
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
            },
            loading:true
        }
    },
    components: {
        datepicker
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
            console.log();
            
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
<style>
.td-label{
    text-align: right;
}
.td-select{
    min-width: 220px;
}

.td-label-sm{
    min-width: 100px;
    text-align: right;
}

.td-select-sm{
    min-width: 50px;
}


@media (min-width: 768px){
    .modal-sm {    
        width: 400px;
    }
}

</style>
