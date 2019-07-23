<template>
    <bootstrap-modal ref="nuevaJornada" :need-header="true" :need-footer="true" :size="'medium'">
        <div slot="title"> Cobros </div>
        <div slot="body">
          <div class="box-body" style="padding-top:0px;">
                <div class="row">
                    <div class="col-md-12" v-if="loading">
                        <p style="font-size:18px;margin-bottom:5px;">Nueva jornada de cobro </p>
                        <p class="text-muted">Crea una nueva jornada de cobro, puedes programar la jornada de cobro</p>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 my-2">
                            <label for="">Cobrador</label>
                            <v-select v-model="cobrador" :options="cobradores" placeholder="Selecciona el cobrador"></v-select>
                        </div>
                        <div class="col-md-6 my-2">
                            <label for="">Ruta</label>
                            <v-select v-model="ruta" :options="rutas" placeholder="Selecciona la ruta"></v-select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 my-2">
                            <label for="">Fecha de inicio</label>
                            <date-picker v-model="inicio" :lang="'es'" type="datetime" format="MM/DD/YYYY [a las] HH:mm" ></date-picker>
                        </div>
                        <div class="col-md-6 my-2">
                            <label for="">Fecha de culminacion</label>
                            <date-picker v-model="culminacion" :lang="'es'" type="datetime" format="MM/DD/YYYY [a las] HH:mm" ></date-picker>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div slot="footer">
            <button class="btn btn-default">Cancelar</button>
            <button class="btn btn-primary" @click="sendCobro"> Guardar </button>
        </div>
    </bootstrap-modal>

</template>
<script>
import DatePicker from 'vue2-datepicker'
import { mapActions, mapGetters } from 'vuex';
import moment from 'moment'
import CobroService from '../../../services/cobros'
export default {
    components: { DatePicker },
    data(){
        return{
            error:'',
            inicio:'',
            culminacion:'',
            cobrador:null,
            ruta:null,
            filtro:{},
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
        let hoy = new Date();
        this.inicio = new Date(hoy.getFullYear(),hoy.getMonth(),hoy.getDate(),7,30,0);
        this.culminacion = new Date(hoy.getFullYear(),hoy.getMonth(),hoy.getDate(),18,0,0);
        this.eventHub.$on('nuevaJornada', ()=>{
            this.resetModal();
            this.$refs.nuevaJornada.open();
        });
    },
    methods:{
        ...mapActions({
            getCobradores:'users/getUsersFormat',
            getRutas:'rutas/getRutasFormat',
        }),
        getData(){
            this.getCobradores();
            this.getRutas();
        },
        sendCobro(){
            let inicio  = moment(this.inicio).format('YYYY-MM-DD HH:mm:ss');
            let culminacion = moment(this.culminacion).format('YYYY-MM-DD HH:mm:ss');

            if(this.cobrador==null){
                return this.$noty.error('Debes seleccionar una cobrador');
            }

            if(this.ruta==null){
                return this.$noty.error('Debes seleccionar una ruta');
            }


            let query = {ruta: this.ruta, cobrador: this.cobrador.id,inicio:inicio,culminacion:culminacion};
            
            CobroService.add(query).then(rs=>{
                this.$noty.success("Se ha creado la jornada de cobro con exito");
                this.$refs.nuevaJornada.close();
            }).catch(err=>{
                this.$noty.error("Se ha producido un error")
            })

        },
        resetModal(){
            this.ruta = null;
            this.cobrador= null;
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
