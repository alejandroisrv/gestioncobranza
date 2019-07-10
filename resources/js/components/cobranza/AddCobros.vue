<template>
    <bootstrap-modal ref="filtrosCobro" :need-header="false" :need-footer="false" :size="'small'">
      <div slot="body">
          <div class="box">
            <div class="box-header">
                  <p style="font-size:18px">Nueva jornada de cobranza</p>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <p style="font-size:18px;" class="mb-1">{{ cobro.ruta.nombre}}  </p>
                        <p class="col-md-6 px-0 text-muted">Número de clientes {{ ruta.items.length }} </p>
                        <p class="col-md-6 text-muted">Municipio {{ruta.municipio.municipio  }}   </p>
                    </div>
                </div>
            </div>
          </div>
      </div>
    </bootstrap-modal>

</template>
<script>
import RutaService from '../../services/rutas';
import { mapActions, mapGetters } from 'vuex';

export default {
    
    data(){
        return{
            cobro : ''
        }
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

        this.eventHub.$on('openCobro', (cobro)=>{
            this.cobro = cobro ;
            this.$refs.filtrosCobro.open();
        });

    },
    methods:{
        ...mapActions({
            getCobradores:'users/getUsersFormat',
            getClientes:'clientes/getClientesFormat',
            getRutas:'rutas/getRutasFormat'
        }),

    }

}
</script>
