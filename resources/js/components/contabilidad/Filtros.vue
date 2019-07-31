<template>
    <bootstrap-modal ref="filtrosCobro" :need-header="false" :need-footer="false" :size="'small'">
      <div slot="body">
          <div class="box-body">
                  <div class="row">
                      <div class="col-md-12" v-if="loading">
                          <p style="font-size:18px">Selecciona el filtro</p>
                            <table class="table col-md-12">
                                <tr>
                                  <td class="td-label">Categoria:</td>
                                  <td class="td-select" v-if="categorias.length > 0 "><v-select v-model="parametros.tipo" :options="categorias" placeholder="Selecciona el cobrador"></v-select></td>
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
                                    <td colspan="2"> <button class="btn btn-primary" @click="filtrar()">  Buscar </button> </td>
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
import { mapActions, mapGetters } from 'vuex';
export default {
    components: { DatePicker },
    data(){
        return{
        fecha:{},
        categorias:[{}],
        parametros : {
            desde:'',
            hasta:'',
            tipo:undefined
        },
        loading:true
        }
    },
    components:{
        "bootstrap-modal": require("vue2-bootstrap-modal")
    },
    created(){
        this.eventHub.$on('openFiltrar', (categorias) =>{
            this.$refs.filtrosCobro.open();
            this.categorias = categorias
        });

    },
    methods:{
        filtrar(){
            let desde = moment(this.parametros.desde ).format('DD/MM/YY');
            let hasta =  moment(this.parametros.hasta ).format('DD/MM/YY');
            let query = {
                tipo:(this.parametros.tipo.id) ? this.parametros.tipo.id : '',
                desde:(desde !='Invalid date') ? desde : '',
                hasta:(hasta !='Invalid date') ? hasta : ''};
            this.eventHub.$emit('filtrarContabilidad',query);
            this.$refs.filtrosCobro.close();
        }
    },
    filters:{
        operacionFiltro(value){
        switch (value) {
            case 1:
                return 'Ingreso'
            break;
            case -1:
                return 'Egreso'
            break;
            default:
                return ''
            break;
        }
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
