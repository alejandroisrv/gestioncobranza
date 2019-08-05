<template>
    <bootstrap-modal ref="Reportes" :need-header="false" :need-footer="false" :size="'small'">
      <div slot="body">
          <div class="box-body">
                  <div class="row">
                      <div class="col-md-12" v-if="loading">
                          <p style="font-size:18px">Exportar reportes a excel</p>
                            <table class="table col-md-12">
                                <tr>
                                  <td class="td-label">Modulo:</td>
                                  <td class="td-select"><v-select v-model="parametros.modulos" :options="modulos" placeholder="Selecciona el modulo"></v-select></td>
                                </tr>
                                                        
                                <template v-if="parametros.modulos !== undefined ">
                                    <tr v-if="parametros.modulos.id == 'mv'">
                                        <td class="td-label">Tipo:</td>
                                        <td class="td-select"><v-select v-model="parametros.tipo" :options="[{id:1,label:'Salidas'},{id:1,label:'Entradas'}]" placeholder="Selecciona la categoria"></v-select></td>
                                    </tr>
                                    
                                    <tr v-if="parametros.modulos.id == 'ls'">
                                        <td class="td-label">Tipo:</td>
                                        <td class="td-select"><v-select v-model="parametros.tipo" :options="[{id:1,label:'Todos'},{id:1,label:'Vendidos'}]" placeholder="Selecciona la categoria"></v-select></td>
                                    </tr>

                                    <tr v-if="parametros.modulos.id == 'cm'">
                                        <td class="td-label">Tipo:</td>
                                        <td class="td-select"><v-select v-model="parametros.tipo" :options="[{id:'all',label:'Todas'},{id:1,label:'Pagadas'},{id:1,label:'No pagadas'}]" placeholder="Selecciona la categoria"></v-select></td>
                                    </tr>

                                    <tr>
                                        <td class="td-label">Fecha:</td>
                                        <td class="td-selct"><v-select v-model="fecha" :options="[{id:'all',label:'Hoy'},{id:'otras', label:'Rango personalizado'}]" placeholder="Selecciona el una opcion para la fecha"></v-select></td>
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
                                        <td class="td-select" v-if="download"> 
                                            <downloadexcel class="btn btn-success" :data="json_data" :fields="json_fields" :name="filename" type ="csv"> 
                                                <i class="fa fa-downlaod"></i> Descargar Excel 
                                            </downloadexcel>
                                        </td>
                                    </tr>
                                </template>
                          </table>
                    </div>
              </div>
          </div>
      </div>
    </bootstrap-modal>

</template>
<script>
import downloadexcel from "vue-json-excel";
import DatePicker from 'vue2-datepicker';
import moment from 'moment';
import ReporteService from '../../services/reportes'
export default {
    components: { "bootstrap-modal": require("vue2-bootstrap-modal"),downloadexcel,DatePicker },
    data(){
        return{
            fecha:'Hoy',
            loading:false,
            download:false,
            modulos:[
                {id:'mv',label:'Movimientos'},
                {id:'ac',label:'Acuerdos de pago'},
                {id:'cm',label:'Comisiones'},
                {id:'ls',label:'Listado de productos'},
                {id:'vn',label:'Ventas'}
            ],
            parametros : {
                modulos:undefined,
                desde:new Date(),
                hasta:new Date(),
                tipo:undefined
            },
            json_fields:{},
            json_data:{},
            filename:'',
        }
    },
    watch:{
        "parametros.tipo"(){
            this.filtrar();
        }
    },
    created(){
        this.eventHub.$on('Reportes', () =>{
            this.$refs.Reportes.open();
            this.loading = true;
        });
    },
    methods:{
        async filtrar(){
            this.download = false;
            
            let desde = moment(this.parametros.desde ).format('DD/MM/YY');
            let hasta = moment(this.parametros.hasta ).format('DD/MM/YY');
            let modulo= this.parametros.modulos.id;
            let tipo  = ( this.parametros.tipo != undefined && this.parametros.tipo.id) ? this.parametros.tipo.id : '';
            let query = { tipo:tipo, desde:desde, hasta:hasta, modulo:modulo};
            
            const rs = await ReporteService.get(query);

            this.json_data = rs.data.data;
            this.json_fields = rs.data.fields;
            this.filename = rs.data.filename;
            
            this.download = true;

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
