
<template>
    <div>
        <bootstrap-modal ref="NuevaRuta" :need-header="true" :need-footer="true" :size="'medium'">
            <div slot="title">{{ titulo }}</div>
            <div slot="body">
                <div class="box-body">
                    <template v-if="step==0">
                        <div class="col-md-12 mb-2">
                            <p style="font-size:18px;" class="mb-1">Configuración de la ruta</p>
                            <p class="text-muted"> Introduce el municipio y un nombre para ruta</p>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                 <v-select v-model="ruta.municipio" :options="municipios" placeholder="Selecciona el municipio"></v-select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" v-model="ruta.nombre" placeholder="Colocale un nombre a la ruta"> 
                            </div>
                        </div>
                        
                    </template>
                    <template v-if="step==1">
                        <div class="col-md-12">
                            <p style="font-size:18px;" class="mb-1">Selecciona los clientes</p>
                            <p class="text-muted"> Intenta buscar por dirección</p>
                        </div>
                     
                        <div class="form-row  mb-1">
                            <div class="col-md-12">
                                <input type="search" class="form-control" v-model="direccion" @keyup="buscarClientes" placeholder="Escribe una direccion para buscar ..."> 
                            </div>
                        </div>
                        <div class="form-row lista-clientes">
                            <div class="col-md-12">
                                <table v-if="clientes.data && clientes.data.length > 0" class="col-md-12 mt-2"> 
                                    <tr class="list-item" v-for="item in clientes.data" :key="item.id" @click="addCliente(item)"> 
                                        <td> <i :class=" item.select ? 'fa fa-check-square-o' : 'fa fa-square-o'" ></i></td>  <td> {{item.nombre}}  {{item.apellido}} </td>  <td>  <small> {{  item.direccion}}</small>  </td> 
                                    </tr>
                                </table>
                                <span class="text-muted" v-if="clientes.data.length==0 && direccion!=''"> No se ha encontrado resultados</span>
                            </div>
                        </div>
                    </template>
                    <template v-if="step==2">
                        <div class="col-md-12 mb-1">
                            <p style="font-size:18px;" class="mb-1">Establece el orden de los clientes</p>
                            <p class="text-muted"> Puedes arrastrar a los clientes para organizarlos </p>
                        </div>
                        <div class="form-row" v-if="list.length>0">
                            <div class="col-md-12 mt-2">
                                <SortableList v-model="list" lockAxis="y" :hideSortableGhost="true">
                                    <SortableItem v-for="(item, index) in list" :index="index" :key="index" :item="item" />
                                </SortableList>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <div slot="footer">
                <button v-if="step>0"  type="button" class="btn btn-default" @click="step--">Atras</button>
                <button v-if="step==1 || step==0" type="submit" class="btn btn-primary" @click="next">Continuar</button>
                <button v-if="step==2" type="submit" class="btn btn-primary" @click="save">Guardar</button>
            </div>
        </bootstrap-modal>
    </div>
</template>
<script>
import Vue from 'vue'
import { SortableList, SortableItem } from './drag.js'
import { mapGetters,mapActions } from 'vuex'
import ClienteService from '../../services/clientes'
import MunicipioService from '../../services/municipios';
import RutaService from '../../services/rutas';
import { setTimeout } from 'timers';
export default {
    data(){
        return {
            clientes:{data:[]},
            titulo:'Nueva ruta',
            direccion:'',
            step:0,
            list:[],
            rutas:[],
            editando:false,
            ruta:{
                nombre:'',
                direccion:{},
                municipio:{},
                seleccionados:{}
            }
        }
    },
    computed:{
        ...mapGetters({
            municipios:'municipios/municipiosFormat'
        }),
        clientesList:{
            set(value){
                this.clientes.data = value;
            },
            get(){
                return this.clientes.data;
            }
        }
    },
    components: {
        "bootstrap-modal": require("vue2-bootstrap-modal"),SortableList, SortableItem
    },
    created(){
        this.getMunicipios();
        this.eventHub.$on('modalRuta', ruta => {
            this.reset();
            if(ruta !== undefined){
                this.ruta.id = ruta.id;
                this.ruta.nombre = ruta.nombre
                this.ruta.municipio = ruta.municipio;
                this.ruta.municipio.label=ruta.municipio.municipio;
                ruta.items.forEach(c=>{
                    this.clientes.data.push(c.cliente);
                    this.list.push(c.cliente)
                });
                this.editando = true;
                this.step = 0;
            }
            this.buscarClientes();
            this.openTheModal();
        })
    }, 
    watch:{
        municipio(){
            this.buscarClientes();
        },
        "clientes.data"(){
            this.marcar();
        },
        list(){
            this.marcar();
        }
    },
    methods:{
        ...mapActions({
            getMunicipios:'municipios/municipiosFormat'
        }),
        marcar(){
            this.clientes.data.forEach( x => {
                this.list.forEach( y => {
                    let id = (this.editando) ? y.cliente_id  : y.id ;
                    if(x.id == y.id){
                        Vue.set(x,'select', true);
                    }
                });    
            })
        },
        addCliente(item){
            if(!item.select){ 
                this.list.push(item);
                Vue.set(item,'select', true);
            }else{
                Vue.set(item,'select', false);
                this.list.forEach((e,i)=>{
                   if(e.id == item.id)  
                    this.list.splice(i,1);
                })
            }
      
        },

        buscarClientes(){
            ClienteService.getAll({direccion:this.direccion, ruta:0 }).then(rs=>{
                this.clientes.data = rs.data.body.data;
            }).catch(rs=>{
                this.$noty.error('Error al intentar encontrar clientes');
            })
        },
        next(){
            this.step++;
            if(this.step==2){
                if(!this.editando){
                    this.list = []
                    this.clientes.data.forEach(e=>{
                        if(e.select) this.list.push({id:e.id, nombre: `${e.nombre}`, direccion: e.direccion});
                    });
                }
            }
        },
        async save(){
            this.ruta.seleccionados = this.list;
            let mensaje;
            
            if (this.ruta.nombre=='') return this.$noty.error('Introduce un nombre para la ruta');
            if (this.ruta.municipio.id == undefined ) return this.$noty.error('Selecciona un minicipio');
            if (this.ruta.seleccionados.length==0) return this.$noty.error('Debes seleccionar al menos un cliente');
            try {
                if(!this.editando) {
                    const rs = await RutaService.add(this.ruta);
                    mensaje = 'Ruta creada con exito';
                }else{
                    const rs = await RutaService.edit(this.ruta);
                    mensaje  = 'Ruta editada con exito';
                }
            } catch (error) {
                this.$noty.error("Ha ocurrido un error: "+error.response);
                return false;
            }
           
            this.$noty.success(mensaje);

            this.eventHub.$emit('sendRuta');
            this.closeTheModal();
            
        },
        reset() {
            this.clientes = {data:[]}
            this.direccion=''
            this.step=0
            this.list=[]
            this.ruta={nombre:'',direccion:'',municipio:'',seleccionados:{}}
            this.editando=false;
        },
        openTheModal() {

            this.$refs.NuevaRuta.open();
        },
        endMove({ event, newIndex, oldIndex, collection }){
            console.log({ event, newIndex, oldIndex, collection });
        },
        closeTheModal() {
            this.$refs.NuevaRuta.close();
        }
    }
}
</script>
<style>

td{
    padding: 5px 10px;
}
.list{
    list-style: none;
}
.list-item{
    font-size: 14px !important;
    
    box-shadow: 0px 0px 1px #c1c1c1c1;
    cursor:pointer;
    z-index:9999;
}
.list-item td {
    padding: 10px;
}
.lista-clientes{

    margin-top: 12px;

}
</style>
