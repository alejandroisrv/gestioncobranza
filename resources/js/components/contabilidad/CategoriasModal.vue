<template>
    <bootstrap-modal ref="CategoriasModal" :need-header="true" :need-footer="true" :size="'medium'">
        <div slot="title"> Categorias </div>
        <div slot="body">
          <div class="box-body">
                  <div class="row">
                      <div class="col-md-12" v-if="loading">
                          <div class="row">
                            <table class="table col-md-12">
                                <tr v-for="(item,i) in categorias" :key="item.id" class="cat-row">
                                    <template v-if="!item.editando">
                                        <td>{{ item.label || item.descripcion }}</td>
                                        <td>
                                            <span :class="item.operacion.id == 1 ? 'label label-success' : 'label label-danger'"> 
                                                {{  item.operacion.label }} 
                                            </span>
                                        </td>
                                        <td class="text-right"> 
                                            <button class="btn btn-default btn-sm" @click="edit(item)"> <i class="fa fa-edit"></i> </button>
                                            <button class="btn btn-danger btn-sm" @click="borrar(item,i)"> <i class="fa fa-trash"></i>  </button> 
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
                            </table>
                        </div>
                        <div class="row">
                            <table class="table col-md-12">
                                <tr class="add-row">
                                    <th colspan="3" style="padding:10px;">Nueva Categoria</th>
                                </tr>
                                <tr class="add-row">
                                    <td style="width:40%">
                                        <input type="text" class="form-control m-1" v-model="categoria.descripcion" placeholder="Introduce la descripción"></td>
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
      </div>
      <div slot="footer">
          <button class="btn btn-primary"> Continuar</button>
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
        return{
        categorias:[{}],
        categoriaEdit:{
            id:'',
            descripcion:'',
            label:'',
            operacion:{}
        },
        categoria : {
            id:0,
            descripcion:'',
            operacion:'',
        },
        loading:false
        }
    },
    components:{
        "bootstrap-modal": require("vue2-bootstrap-modal")
    },
    created(){
        this.eventHub.$on('openCategorias', (categorias) =>{
            this.categorias = categorias
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
            console.log(item); 

        },
        borrar(item,i){

            ContabilidadService.deleteCategory(item.id).then(rs=>{
                this.categorias.splice(i,1)
                this.$noty.success('Categoria eliminada con exito');
                console.log(rs);
            });
           
            
        },
        save(){
            if(this.validationDescripcion() && this.validationOperacion() ) {
                let label  = this.categoria.operacion.label;
                this.categoria.operacion = this.categoria.operacion.id;
                ContabilidadService.addCategory(this.categoria)
                this.categoria.operacion = {id: this.categoria.operacion, label:label };
                this.categorias.push(this.categoria);
                this.categoria  = { descripcion:'', operacion:undefined };
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
.cat-row{
    box-shadow:0px 0px 1px gray;
    padding: 10px;
}
.add-row{

    padding: 10px;

}
@media (min-width: 768px){
    .modal-sm {    
        width: 600px;
    }
}

</style>
