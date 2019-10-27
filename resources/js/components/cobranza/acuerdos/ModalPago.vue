<template>

        <bootstrap-modal ref="PagoCliente" :need-header="true" :need-footer="true" :size="'medium'">
            <div slot="title">Detalle del acuerdo </div>
            <div slot="body">
                 <div class="box-body">
                    <div class="row">
                        <div class="col-md-12" v-if="!loading">
                            <p style="font-size:18px;margin-bottom:5px;">Registrar nuevo abono</p>
                            <p class="text-muted">Selecciona un acuerdo de pago, el cliente e ingresa el monto abonado</p>
                            <!-- <p class="text-danger m-0">Selecciona un acuerdo de pago, el cliente e ingresa el monto abonado</p> -->
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 my-2">
                                <label for="">Cliente:</label>
                                <v-select v-model="pago.user_id" :options="clientes" placeholder="Selecciona el cliente"></v-select>
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="">Acuerdo de pago:</label>
                                <v-select v-model="pago.acuerdo_id" :options="acuerdos" placeholder="Selecciona el acuerdo de pago"></v-select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 my-2">
                                <label for="">Monto</label>
                                <input type="text" v-model="pago.monto" class="form-control" placeholder="Introduce el monto">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div slot="footer">
                <button class="btn btn-danger" @click="close()">Cancelar</button>
                <button class="btn btn-primary" @click="send()">Añadir</button>
            </div>
        </bootstrap-modal>

</template>
<script>
import AcuerdoService from '../../../services/acuerdos_pagos'
import ClienteService from '../../../services/clientes';
export default {
    data(){
        return {
            showDetails:'',
            loading:false,
            clientes:[],
            acuerdos:[],
            pago:{
                user_id:'',
                acuerdo_id:'',
                monto:'',
            }
        }
    },
    components: {
        "bootstrap-modal": require("vue2-bootstrap-modal")
    },
    created(){
        this.eventHub.$on('PagoCliente', acuerdo =>{
            this.open();
        });
        this.getClientes();
    },
    methods:{
       async getClientes(){
            const rs = await ClienteService.getAll();
            console.log(rs.data.body);
            rs.data.body.data.forEach(element => {
                this.clientes.push({id:element.id,label:element.nombre});
            });
        },
        async getAcuerdos(id){
            const rs = await AcuerdoService.getAll({cliente:id});
            console.log(rs.data.body);
            this.acuerdos = [];
            rs.data.body.data.forEach(element => {
                this.acuerdos.push({
                    id:element.id,
                    venta_id:element.venta_id,
                    label: `${element.venta.cod} - ${element.periodo_pago} - Monto: ${element.monto} ` 
                    });
            });
        },
       async send(){
            console.log(this.pago);
            let pago = {
                user_id:this.pago.user_id.id,
                acuerdo_id:this.pago.acuerdo_id.id,
                monto:this.pago.monto,
                venta_id:this.pago.acuerdo_id.venta_id
            }
            const rs = await  AcuerdoService.nuevoPago(pago);

            if(rs.data.response){
                this.close();   
                this.eventHub.$emit('getPagos');
            }
        },
        open(){
            this.$refs.PagoCliente.open();
        },
        close(){
            this.$refs.PagoCliente.close();
        },
    },
    watch: {
        "pago.user_id"() {
            this.getAcuerdos(this.pago.user_id.id);
        },
    },


}
</script>
