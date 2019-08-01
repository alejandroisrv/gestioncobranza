<template>
    <bootstrap-modal ref="AddTransacciones" :need-header="true" :need-footer="true" :size="'medium'">
    <div slot="title"> Añadir transaccion</div>
    <div slot="body">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12" v-if="loading">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Nueva Transacción</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <label>Descripción</label>
                            <input type="text" v-model="transaccion.descripcion" class="form-control" placeholder="Introduce una descripcion de la transaccion">
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-4">
                            <label>Monto</label>
                            <input type="text" v-model="transaccion.monto" class="form-control" placeholder="Introduce el monto">
                        </div>
                        <div class="col-md-6">
                            <label>Tipo de transacción</label>
                            <v-select v-model="transaccion.tipo" :options="categorias" placeholder="Selecciona un tipo"></v-select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div slot="footer">
        <button class="btn btn-danger"> Cancelar</button>
        <button class="btn btn-primary" @click="save">Guardar</button>
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
            console.log(this.categorias);
            
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
