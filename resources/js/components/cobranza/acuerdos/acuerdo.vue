<template>

        <bootstrap-modal ref="verAcuerdo" :need-header="true" :need-footer="true" :size="'medium'">
            <div slot="title">Detalle del acuerdo </div>
            <div slot="body">
                 <div class="box-body" v-if="acuerdo!=''">
                     <div class="row">
                        <div class="col-md-12">
                            <p style="font-size:18px;" class="mb-1"> Acuerdo de pago por venta {{ acuerdo.venta.tipos_ventas.descripcion }} </p>
                            <p class="col-md-6 pr-2 pl-1 text-muted fecha-text">{{  acuerdo.created_at | moment('calendar') }}   </p>
                            <p class="col-md-6 px-0 text-muted"> Cliente: {{ acuerdo.cliente.nombre }} {{ acuerdo.cliente.apellido }} </p>
                            <p class="col-md-6 px-0 text-muted"> Vendedor: {{ acuerdo.venta.vendedor.name }}  </p>

                        </div>
                     </div>
                     <div class="row">
                         <div class="col-md-12">
                            <p class="col-md-4 px-0 text-muted"> Periodo de Pago: {{ acuerdo.periodo_pago }}  </p>
                            <p class="col-md-2 px-0 text-muted"> Cuotas: {{ acuerdo.cuotas }}  </p>
                            <p class="col-md-3 px-0 text-muted"> Cuotas pagas: {{ acuerdo.cuotas_pagadas }}  </p>
                         </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                            <p class="col-md-12 px-0 text-muted"> Monto total: {{ acuerdo.monto | currency }}  </p>
                        </div>
                     </div>
                     <div class="row">
                         <div class="col-md-12">
                            <p class="col-md-6 px-0 text-muted"> Fecha final: {{ acuerdo.finished_at | moment('calendar') }}    </p>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-8">
                            <p class="col-md-12 mb-1 px-0" style="font-size:18px"> Abonos </p>
                            <table class="table table-condensed table-bordered table-active">
                                <tr><th class="px-0 pb-0"> Monto</th> <th >Fecha </th> </tr>
                                <tr v-for="abono in acuerdo.abonos">
                                    <td class="px-0 pb-0">{{ abono.monto | currency  }}</td><td>  {{ abono.created_at | moment('DD/MM/YYYY')  }} </td> 
                                </tr>
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
export default {
    
    data(){
        return {
            showDetails:'',
            acuerdo:''
        }
    },
    components: {
        "bootstrap-modal": require("vue2-bootstrap-modal")
    },
    created(){
        this.eventHub.$on('verAcuerdo', acuerdo =>{
            console.log(acuerdo);
            this.acuerdo = acuerdo
            this.open();
        });
    },
    methods:{
        open(){
            this.$refs.verAcuerdo.open();
        },
        close(){
            this.$refs.verAcuerdo.close();
        },

    }


}
</script>
