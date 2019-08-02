<template>
    <bootstrap-modal ref="SelectCartera" :need-header="false" :need-footer="false" :size="'small'">
      <div slot="body">
          <div class="box-body">
                  <div class="row">
                      <div class="col-md-12" v-if="loading">
                          <p style="font-size:18px">Selecciona la cartera</p>
                            <table class="table col-md-12">
                                <tr>
                                  <td class="td-label">Ruta:</td>
                                  <td class="td-select" v-if="rutas.length > 0 "><v-select v-model="parametros.ruta" :options="rutas" placeholder="Selecciona la ruta"></v-select></td>
                                </tr>
                                <tr>
                                  <td class="td-label">Fecha:</td>
                                  <td class="td-selct"><v-select v-model="fecha" :options="[{id:'all',label:'Todas'},{id:'otras', label:'Rango personalizado'}]" placeholder="Selecciona el una opcion para la fecha"></v-select></td>
                                </tr>
                                <tr v-if="fecha.id =='otras'">
                                  <td class="td-label">Desde</td>
                                  <td class="td-select"><date-picker v-model="parametros.desde" :lang="'es'" width="220" format="DD/MM/YY"></date-picker></td>
                                </tr>
                                <tr v-if="fecha.id =='otras'">
                                  <td class="td-label">Hasta</td>
                                  <td class="td-select"><date-picker v-model="parametros.hasta" :lang="'es'" width="220" format="DD/MM/YY"></date-picker></td>
                                </tr>
                                <tr>
                                    <td class="td-label"></td>
                                    <td class="td-select"> <button class="btn btn-primary" @click="filtrar()"> <i class="fa fa-search"></i> Buscar </button> </td>
                                </tr>
                          </table>
                    </div>
              </div>
          </div>
      </div>
    </bootstrap-modal>
</template>
<script>
import DatePicker from 'vue2-datepicker';
import moment from 'moment';
import { mapGetters,mapActions } from 'vuex';
import p from '../../../utils';
export default {
    data(){
        return{
        fecha:'Todas',
        parametros : {
            desde:null,
            hasta:null,
            ruta:undefined
        },
        loading:true
        }
    },
    components:{
        "bootstrap-modal": require("vue2-bootstrap-modal"), DatePicker 
    },
    computed:{
        ...mapGetters({rutas:'rutas/rutasFormat'}),
    },
    created(){
        this.getRutas();
        this.eventHub.$on('SelectCartera', () =>{
            this.$refs.SelectCartera.open();
        });
    },
    methods:{
        ...mapActions({getRutas:'rutas/getRutasFormat'}),
        filtrar(){
            let desde = (this.parametros.desde != null) ? moment(this.parametros.desde ).format('DD/MM/YY') : '' ;
            let hasta = (this.parametros.hasta != null) ? moment(this.parametros.hasta ).format('DD/MM/YY') : '';
            this.$router.push({name:'Cartera',params:{ruta:this.parametros.ruta.id }, query: { desde:desde, hasta:hasta}});
            this.$refs.SelectCartera.close();
        }
    },

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
