<template>
   <bootstrap-modal ref="AddTransacciones" :need-header="true" :need-footer="true" :size="'medium'">
        <div slot="title"> Contabilidad </div>
        <div slot="body">
          <div class="box-body" style="padding-top:0px;">
                <div class="row" v-if="loading">
                    <div class="col-md-12">
                        <p style="font-size:18px;margin-bottom:5px;"> Transacción </p>
                        <p class="text-muted">Añade una nueva transacción</p>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 my-2">
                            <label for="">Descripción</label>
                            <input type="text" v-model="transaccion.descripcion" class="form-control" placeholder="Introduce una descripcion de la transaccion">
                        </div>
                        <div class="col-md-6 my-2">
                            <label for="">Monto</label>
                            <input type="text" v-model="transaccion.monto" class="form-control" placeholder="Introduce el monto">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 my-2">
                            <label for="">Categoria</label>
                            <v-select v-model="transaccion.tipo" :options="categorias" placeholder="Selecciona un tipo"></v-select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div slot="footer">
            <button class="btn btn-danger" @click="close">Cancelar</button>
            <button class="btn btn-primary" @click="save"> Guardar </button>
        </div>
    </bootstrap-modal>
</template>
<script>
import ContabilidadService from '../../services/contabilidad'
export default {
    data(){
        return {
            loading:false,
            transaccion : {
                tipo:undefined,
                monto:'',
                descripcion:''
            },
        }
    },
    components:{
        "bootstrap-modal": require("vue2-bootstrap-modal")
    },
    computed:{
        categorias:{
            set(value){
                this.$store.commit('contabilidad/SET_CATEGORIAS',value);
            },
            get(){
                return this.$store.state.contabilidad.categorias;
            }
        }
    },
    created(){
        this.eventHub.$on('AddTransacciones', () =>{
            this.$refs.AddTransacciones.open();
            this.loading = true;
        });
    },
    methods:{
        save(){
            try {
                ContabilidadService.add(this.transaccion)
                this.eventHub.$emit('filtrarContabilidad',{});
                this.$refs.AddTransacciones.close();
            } catch (error) {
                this.$noty.error('Se ha producido un error: '+ error);
            }
            
        },
        close(){
            this.$refs.AddTransacciones.close();
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
