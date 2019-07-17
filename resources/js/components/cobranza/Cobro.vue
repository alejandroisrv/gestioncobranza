<template>

        <bootstrap-modal ref="verCobro" :need-header="true" :need-footer="true" :size="'medium'">
            <div slot="title">Detalle de la cobro </div>
            <div slot="body">
                 <div class="box-body" v-if="cobro!=''">
                     <div class="row">
                        <div class="col-md-12">
                            <p style="font-size:18px;" class="mb-1"> Jornada de Cobro </p>
                            <p class="col-md-12 pl-1 text-muted">  Cobrador {{ cobro.cobrador.name }} </p>
                            <p class="col-md-6 pr-0 pl-1 text-muted">Inicia {{  cobro.fecha_inicio | moment('calendar') }}   </p>
                            <p class="col-md-6 pr-0 pl-1 text-muted">  Culmina {{ cobro.fecha_culminacion | moment('calendar')  }}   </p>
                            
                        </div>
                     </div>
                     <div class="row">
                         <div class="col-md-12">
                             <p style="font-size:16px;" class="mb-1"> Orden de la ruta </p>
                             <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Dirección</th>
                                        <th>Monto</th>
                                        <th>Comisión</th>
                                        <th>Estado</th>
                                        <th>Culminación</th>
                                    </tr>
                                </thead> 

                                <div v-for="item in cobro.items" :key="item.id" style="display:contents">
                                    <tr @click="showDetail(item.id)"> 
                                        <td>{{ item.ruta_items.cliente.nombre}} {{item.ruta_items.cliente.apellido}}</td>
                                        <td>{{ item.ruta_items.cliente.direccion}}</td>
                                        <td>{{ item.monto | currency }}</td>
                                        <td>{{ item.comision | currency  }} </td>
                                        <td>{{ item.estado | cobrosEstado(item.estado) }}</td>
                                        <td>{{ item.fecha_culminacion | moment('calendar') }}  </td>
                                    </tr>
                                    <tr v-show="showDetails == 'detail'+item.id" style="font-size:13px;">
                                        
                                        <td :colspan="item.observacion!=null ? 4 : 2"><span v-if="item.observacion!=null">{{ item.obervacion }}  </span> <span v-else>Sin obersevación</span> </td>
                                        <td :colspan="item.observacion!=null ? 2 : 4">Ver acuerdo de pago</td>       
                                    </tr>
                                </div>
                            </table>
                         </div>
                     </div>
                </div>
            </div>
            <div slot="footer">
                <button class="btn btn-primary" @click="close">Continuar</button>
            </div>
        </bootstrap-modal>

</template>
<script>
import moment from 'moment'
export default {
    
    data(){
        return {
            showDetails:'',
            cobro:''
        }
    },
    components: {
        "bootstrap-modal": require("vue2-bootstrap-modal")
    },
    created(){
        this.eventHub.$on('verCobro', cobro =>{
            console.log(cobro);
            this.cobro = cobro
            this.open();
        });
    },
    methods:{
        showDetail(id){
            let showDetail ='detail'+id;
            if(showDetail==this.showDetails){
                this.showDetails = '';
            }else{
                this.showDetails = showDetail;
            }
        },
        open(){
            this.$refs.verCobro.open();
        },
        close(){
            this.$refs.verCobro.close();
        },

    }


}
</script>
