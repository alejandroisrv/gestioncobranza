<template>
    <bootstrap-modal ref="CategoriasModal" :need-header="true" :need-footer="true" :size="'medium'">
        <div slot="title"> Categorias </div>
        <div slot="body">
          <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table col-md-12">
                        <tr v-for="(item,i) in categorias" :key="item.id" class="cat-row" > 
                            <template v-if="!item.editando">
                                <td>{{ item.label || item.descripcion }}</td>
                                <td>
                                    <span :class="item.operacion.id == 1 ? 'label label-success' : 'label label-danger'"> 
                                        {{  item.operacion.label }} 
                                    </span>
                                </td>
                                <td class="text-right"> 
                                    <button class="btn btn-default btn-sm" @click="edit(item)"> <i class="fa fa-edit"></i> </button>
                                    <button class="btn btn-danger btn-sm" @click="borrar(item,i)" v-if="item.delete"> <i class="fa fa-trash"></i>  </button> 
                                </td>
                            </template>
                            <template v-else>
                                <td>
                                    <input type="text" class="form-control m-1" v-model="categoriaEdit.label" placeholder="Introduce la descripción"></td>
                                <td style="width:200px;">
                                    <v-select v-model="categoriaEdit.operacion"  :options="[{id:1,label:'Abono'},{id:-1, label:'Cargo'}]" placeholder="Selecciona una tipo"></v-select></td>
                                <td class="text-right">
                                    <button class="btn btn-primary m-1 btn-sm" style="margin-top: -4px;" @click="update"> <i class="fa fa-save"></i> </button>
                                </td>
                            </template>
                        </tr>
                        <tr v-if="categorias.length == 0">
                            <td colspan="3"> No hay categorias agregadas</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table col-md-12">
                        <tr class="add-row">
                            <th colspan="3" style="padding-bottom:10px;">Nueva Categoria</th>
                        </tr>
                        <tr class="add-row">
                            <td style="width:40%;padding-left:0px!important;">
                                <input type="text" class="form-control" v-model="categoria.descripcion" placeholder="Introduce la descripción"></td>
                            <td style="width:40%">
                                <v-select v-model="categoria.operacion"  :options="[{id:1,label:'Abono'},{id:-1, label:'Cargo'}]" placeholder="Selecciona una tipo"></v-select></td>
                            <td style="width:20%;text-aling:right;">
                                <button class="btn btn-primary m-1 btn-block" style="margin-top: -4px;" @click="save"> Agregar </button>
                            </td>
                        </tr>
                    </table>                        
                </div>
            </div>
        </div>
      </div>
      <div slot="footer">
          <button class="btn btn-primary" @click="close"> Continuar</button>
      </div>
    </bootstrap-modal>
</template>
<script>
import ContabilidadService from '../../services/contabilidad';
import DatePicker from 'vue2-datepicker'
import { mapActions, mapGetters } from 'vuex';
import Vue from 'vue'
export default {
    components: { DatePicker },
    data(){
        return {
            categoriaEdit:{
                id:'',
                descripcion:'',
                label:'',
                operacion:{}
            },
            categoria : {
                id:0,
                descripcion:'',
                label:'',
                operacion:'',
                delete:true,
            },
            loading:false
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
        this.eventHub.$on('openCategorias', () =>{
            this.$refs.CategoriasModal.open();
            this.loading = true;
        });
    },
    methods:{
        async update(){
            this.categorias.forEach(x=> {
                Vue.set(x,'editando',false)            
                if(x.id == this.categoriaEdit.id){              
                    x.label = this.categoriaEdit.label ;
                    x.operacion.id = this.categoriaEdit.operacion.id ;
                    x.operacion.label = this.categoriaEdit.operacion.label ;
                }
            });
            const rs = await ContabilidadService.updateCategory(this.categoriaEdit);
            this.$noty.success("Categoria actualizada con exito");
        },
        edit(item){
            this.categorias.forEach(x=> {
                Vue.set(x,'editando',false)            
            });
            
            this.categoriaEdit.id = item.id;
            this.categoriaEdit.descripcion = item.descripcion;
            this.categoriaEdit.label = item.label;
            this.categoriaEdit.operacion.id = item.operacion.id;
            this.categoriaEdit.operacion.label = item.operacion.label;
            Vue.set(item,'editando',true)

        },
        borrar(item,i){
            this.$confirm('Estas seguro que desea borrar');
            ContabilidadService.deleteCategory(item.id).then(rs=>{
                this.categorias.splice(i,1)
                this.$noty.success('Categoria eliminada con exito');
            }).catch(err=>{
                this.$noty.error('Se ha producido un error');
            });
        },
        async save(){
            if(this.validationDescripcion() && this.validationOperacion() ) {
                const cat = await ContabilidadService.addCategory(this.categoria);
                this.categoria.id = cat.data.id;
                this.categoria.label = cat.data.descripcion;
                this.categorias.push(this.categoria );
                this.categoria  = { descripcion:'', operacion:undefined,label:'',id:0};
            }
        },
        validationDescripcion(){
            if(this.categoria.descripcion !=='' ){ 
                return true;
            }else { 
                this.$noty.error('Debe colocar una descripcion');
                return false;
            }
        },
        validationOperacion(){
            if(this.categoria.operacion.id !== undefined ){ 
                return true;
            }else { 
                this.$noty.error('Debe colocar un tipo ');
                return false;
            }
        },
        close(){
            this.categoria = {
                id:0,
                descripcion:'',
                label:'',
                operacion:'',
                delete:true,
            }
            this.$refs.CategoriasModal.close();
        }
    },

}
</script>
<style>
.cat-row{
    box-shadow:0px 0px 1px gray;
    padding: 10px;
}
@media (min-width: 768px){
    .modal-sm {    
        width: 600px;
    }
}

</style>
