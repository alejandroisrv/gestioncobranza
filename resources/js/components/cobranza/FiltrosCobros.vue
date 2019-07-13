<template>
    <bootstrap-modal ref="filtrosCobro" :need-header="false" :need-footer="false" :size="'small'">
      <div slot="body">
          <div class="box-body">
                  <div class="row">
                      <div class="col-md-12" v-if="loading">
                          <p style="font-size:18px">Selecciona el filtro</p>
                          <table class="table col-md-12">
                              <tr>
                                  <td class="td-label">Cliente:</td>
                                  <td class="td-select"><v-select v-model="filtro.cliente" :options="clientes" placeholder="Selecciona un cliente"></v-select></td>
                              </tr>
                              <tr>
                                  <td class="td-label">Cobrador:</td>
                                  <td class="td-select"><v-select v-model="filtro.cobrador" :options="cobradores" placeholder="Selecciona el cobrador"></v-select></td>
                              </tr>
                              <tr>
                                  <td class="td-label">Ruta:</td>
                                  <td class="td-selct"><v-select v-model="filtro.ruta" :options="rutas" placeholder="Selecciona el municipio"></v-select></td>
                              </tr>
                              <tr>
                                  <td class="td-label">Fecha:</td>
                                  <td class="td-selct"><v-select v-model="filtro.fecha" :options="[{id:'all',label:'Todas'},{id:'otras', label:'Rango personalizado'}]" placeholder="Selecciona el una opcion para la fecha"></v-select></td>
                              </tr>
                              <tr  v-if="filtro.fecha.id =='otras'">
                                  <td class="td-label">Desde</td>
                                  <td class="td-select"><date-picker v-model="filtro.desde" :lang="'es'" width="220" format="DD/MM/YY"></date-picker></td>
                              </tr>

                              <tr v-if="filtro.fecha.id =='otras'">
                                  <td class="td-label">Hasta</td>
                                  <td class="td-select"><date-picker v-model="filtro.hasta" :lang="'es'" width="220" format="DD/MM/YY"></date-picker></td>
                              </tr>

                              <tr>
                                <td class="td-label"></td>
                                <td class="td-select my-2"><button class="btn btn-primary" @click="filtrar"> <i class="fa fa-search"></i> Buscar</button></td>
                              </tr>
                          </table>
                    </div>
              </div>
          </div>
      </div>
    </bootstrap-modal>

</template>
<script>
import DatePicker from 'vue2-datepicker'
import RutaService from '../../services/rutas';
import { mapActions, mapGetters } from 'vuex';
import moment from 'moment'

export default {
    components: { DatePicker },
    data(){
        return{
            filtro:{
                fecha:{id:'all',label:'Todas'},
                cliente:{id:'all',label:'Todos'},
                cobrador:{id:'all',label:'Todos'},
                ruta:{id:'all',label:'Todas'},
                desde:'all',
                hasta:'all'
            },
            loading:true
        }
    },
    computed:{
        ...mapGetters({
            clientes:'clientes/clientesFormat',
            cobradores:'users/usersFormat',
            rutas:'rutas/rutasFormat'
        }),
    },
    components:{
        "bootstrap-modal": require("vue2-bootstrap-modal")
    },
    created(){
        this.getData()
        this.eventHub.$on('openFiltrar', ()=>{
            this.$refs.filtrosCobro.open();
        });

    },
    methods:{
        ...mapActions({
            getCobradores:'users/getUsersFormat',
            getClientes:'clientes/getClientesFormat',
            getRutas:'rutas/getRutasFormat',
            getCobros:'cobros/getCobrosAll'
        }),
        getData(){
            this.getCobradores();
            this.getClientes();
            this.getRutas();
        },
        filtrar(){
            let desde = moment(this.filtro.desde ).format('DD/MM/YY');
            let hasta =  moment(this.filtro.hasta ).format('DD/MM/YY');
            let query = {cliente: this.filtro.cliente.id, cobrador:this.filtro.cobrador.id,
                         ruta:this.filtro.ruta.id,
                        desde:(desde !='Invalid date') ? dasde : '',
                        hasta:(hasta!='Invalid date' ? hasta : '')};
    
            this.getCobros(query);
            //this.$refs.filtrosCobro.close();
        }
    }

}
</script>
<style>
tr{
    max-width: 100px !important;
}

.td-label{
    text-align: right;
}
.td-select{
    min-width: 220px;
    max-width: 220px;
}

.td-label-sm{
    max-width: 50px;
    min-width: 50px;
    text-align: right;
}

.td-select-sm{
    max-width: 50px;
    min-width: 50px;
}

.mx-input-append {
    height: inherit !important;
}
.mx-input-wrapper {
    max-width: 235px;
    min-width: 235px;
    width: 233px;
}   

@media (min-width: 768px){
    .modal-sm {    
        width: 400px;
    }
}

</style>
