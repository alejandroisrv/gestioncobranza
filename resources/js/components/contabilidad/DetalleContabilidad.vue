<template>
   <bootstrap-modal ref="VerDetalle" :need-header="true" :need-footer="true" :size="'medium'">
        <div slot="title"> Contabilidad </div>
        <div slot="body">
          <div class="box-body" style="padding-top:0px;">
                <div class="row">
                    <div class="col-md-12" v-if="!loading">
                        <p style="font-size:18px;margin-bottom:10px;"> Transacción </p>
                        <p class="mb-0" style="font-size:16px;"> {{ item.descripcion }}</p>
                        <p class="mb-2">{{ item.type.descripcion  }}, representa un {{item.type.operacion | operacionFiltro }} </p>
                        <p class="mb-0 fecha-text"> Fecha: {{ item.created_at | moment('DD/MM/YYYY')  }} <small class=" mx-1 text-muted">Creado por: {{ item.usuario.name }}</small> </p>
                        
                    </div>
                </div>
            </div>
        </div>
        <div slot="footer">
            <button class="btn btn-default" @click="out"> Continuar </button>
        </div>
    </bootstrap-modal>
</template>
<script>
import DatePicker from 'vue2-datepicker';
import moment from 'moment';

export default {
    components: { DatePicker },
    data(){
        return{
            item:{},
            loading:true
        }
    },
    components:{
        "bootstrap-modal": require("vue2-bootstrap-modal")
    },
    created(){
        this.eventHub.$on('VerDetalle', item =>{
            this.item = item;
            this.loading = false;
            this.$refs.VerDetalle.open();
        });
    },
    methods:{
        out(){
            this.$refs.VerDetalle.close();
        }
    },
    filters:{
        operacionFiltro(value){
        switch (value) {
            case 1:
                return 'abono'
            break;
            case -1:
                return 'cargo'
            break;
            default:
                return ''
            break;
        }
        }
    }

}
</script>
