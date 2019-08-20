<template>
    <div>
        <template v-for="(item, index) in items">
            <div class="item-contenido-avanzado d-flex" :key="item.id+'parent'">
                <div class="buttons-left">
                    <span class="handle"><i class="fa fa-arrows handle" aria-hidden="true"></i></span>
                    <button v-if="!item.showChildren" class="btn btn-sm link-caret slot-open-close" @click="openItem(item, index)"><i class="fa fa-plus-square" aria-hidden="true"></i></button>
                    <button v-else class="btn btn-sm link-caret slot-open-close" @click="closeItem(item, index)"><i class="fa fa-minus-square" aria-hidden="true"></i></button>
                    <button @click="openContent(item)" class="btn btn-sm  btn-success" rel="tooltip" :title="!item.showContens ? 'Ver contenido del item' : 'Ocultar contenido del item'">
                        <template v-if="!item.showing">
                            <i v-if="!item.showContens" class="fa fa-eye" aria-hidden="true"></i>
                            <i v-else class="fa fa-eye-slash" aria-hidden="true"></i>
                        </template>
                        <template v-else>
                            <i  class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        </template>
                        
                    </button>
                </div>
                <div class="titulo">
                    <template v-if="!item.editing">     
                        <template v-if="!item.input">
                            <span class="titulo-name">
                                {{ item.titulo }}
                            </span>
                            <span class="slot-btn-add-sub">
                                <a href="#" @click="addSubItem(item)" class="btn btn-siip-accept btn-sm btn-add-sub" title="Agregar subindice" data-toggle="tooltip" data-placement="top"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
                            </span>
                        </template>
                        <template v-else>
                            <span class="titulo-name">
                                <input type="text" class="form-control" v-model="item.titulo" autofocus  @keyup.esc="cancel(item,index)" @keyup.enter="item.nivel === 0 ? saveItem(item, index) : saveSubItem(item, index)"/>
                            </span>
                        </template>
                    </template>
                    <template v-else>
                        <span class="titulo-name">
                            <input type="text" class="form-control" v-model="item.titulo" autofocus  @keyup.esc="cancelEdit(item,index)" @keyup.enter="updateItem(item, index)"/>
                        </span>
                    </template>
                </div>
                <div class="buttons-right">
                    <button :disabled="item.input" @click="editItem(item, index)" class="btn btn-sm btn-option"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></button>
                    <button :disabled="item.input" @click="deleteItem(item, index)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></button>
                </div>
            </div>
            <slide-up-down :active="item.showContens" :duration="500" :key="item.id+item.id">
                <div class="content-item-container">
                    <div class="row">
                        <div class="col-lg-10">
                            <input type="text" class="form-control" v-model="item.subtitulo" @keydown.enter="saveSubtitulo(item)" placeholder="Subtitulo"/>
                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-xs btn-option" style="padding: 3px;" @click="saveSubtitulo(item)">
                                Cambiar <i class="fa fa-refresh"></i>
                            </button>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ca-titulo-item-extra">
                                    <span>
                                        Datos extras para este item <a @click="showExtras(item)" rel="tooltip" :title="!item.showExtras ? 'Expandir' : 'Contraer'"  class="ca-extras-expand" href="javascript:void(0);"><i :class="!item.showExtras ? 'fa fa-plus-square' : 'fa fa-minus-square'" aria-hidden="true"></i></a>
                                    </span>
                                </div>
                                <slide-up-down :active="item.showExtras">
                                    <div class="ca-datos-extras">
                                        <div class="row">
                                            <div class="col-2">
                                                <input type="text" :id="`fp-${item.id}`" class="datepicker form-control" placeholder="Fecha de publicación" v-model="item.extras.fecha_publicacion">
                                            </div>
                                            <div class="col-2">
                                                <input type="text" :id="`fe-${item.id}`" class="form-control" placeholder="Fecha de emisión" v-model="item.extras.fecha_emision">
                                            </div>
                                            <div class="col-2">
                                                <select class="form-control" style="width: 100%; height: 33px;" v-model="item.extras.ente_emisor">
                                                    <option v-for="emisor in $store.state.entes" :value="emisor.id" :key="emisor.alias">{{ emisor.nombre }}</option>
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <select class="form-control" style="width: 100%; height: 33px;" @change="loadSubCategorias(item.extras.categoria)" v-model="item.extras.categoria"> 
                                                    <option v-for="cat in $store.state.categorias" :value="cat.id" :key="cat.alias">{{ cat.nombre }}</option>
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <select class="form-control" style="width: 100%; height: 33px;" v-model="item.extras.subCategoria" :disabled="Object.keys($store.state.subCategorias).length == 0">
                                                    <option v-for="subCat in $store.state.subCategorias" :value="subCat.id" :key="subCat.alias">{{ subCat.nombre }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 5px;">
                                            <div class="col-2">
                                                <select class="form-control" style="width: 100%; height: 33px;" v-model="item.extras.tipo">
                                                    <option v-for="tipo in $store.state.tipo" :value="tipo.id" :key="tipo.alias">{{ tipo.nombre }}</option>
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <input type="text" class="datepicker form-control" placeholder="Numero" v-model="item.extras.numero">
                                            </div>
                                            <div class="col-3">
                                                <select class="form-control" style="width: 100%; height: 33px;" v-model="item.extras.observancia">
                                                    <option value="N">No Obligatoria</option>
                                                    <option value="O">Obligatoria</option>
                                                </select>
                                            </div>
                                            <div class="col-2">
                                                <button v-if="!item.extras.saving" class="btn btn-xs btn-option" style="padding: 3px;" @click="saveExtras(item)">Guardar <i class="fa fa-save"></i></button>
                                                <button v-else class="btn btn-xs btn-option" style="padding: 3px;"><i class="fa fa-spinner fa-spin"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </slide-up-down>
                            </div>
                        </div>
                    <div class="row ca-contenido">
                        <div class="col-lg-12">
                            <div class="ca-titulo-item-extra">
                                <span>
                                    Contenido
                                </span>
                            </div>
                        </div>
                        <div class="no-content" v-if="item.contenidos.length == 0">Aun no se ha añadido contenido</div>
                        <content-item v-else :items="item"></content-item>
                    </div>
                    <div class="row mt-4 p5">
                        <div class="col-lg-6">
                            <button @click="addContentItem(item)" class="btn btn-md btn-block btn-addcontent">
                                Agregar Contenido
                            </button>
                        </div>
                        <div class="col-lg-6">
                            <button @click="addIncorporar(item)" class="btn btn-md btn-block btn-incorporar">
                                Incorporar
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ca-titulo-item-extra">
                                <span>
                                    Enlaces y Archivos
                                </span>
                            </div>
                            <div class="ca-datos-extras">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="ca-item-enlace-menu">
                                            <li class="ca-item-enlace" @click="consultarJrs(item)">
                                                Jurisprudencias ({{ item.jurisprudencias_count }})
                                            </li>
                                            <li class="ca-item-enlace" @click="consultarInformes(item)">
                                                Informes ({{ item.informes_count }})
                                            </li>
                                            <li class="ca-item-enlace" @click="consultarAnalisis(item)">
                                                Analisis Legal ({{ item.analisis_count }})
                                            </li>
                                            <li class="ca-item-enlace" @click="consultarAdjuntos(item)">
                                                Adjuntos ({{ item.adjuntos_count }})
                                            </li>
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="ca-item-enlace-container">
                                            <div class="ca-no-item-enlace" v-if="whatShow == ''">
                                                Haga click en un item de la izquierda para consultar
                                            </div>
                                            <div class="ca-items-enlaces" v-if="whatShow == 'jr'">
                                                <div v-if="item.jurisprudencias.length > 0" class="lists-jurisprudencias">
                                                    <li  class="item-attach" v-for="(j, indexj) in item.jurisprudencias" :key="j.id+'a'">{{ j.tipo.nombre }} - {{ j.valor_tipo }} <span @click="quitarJurisprudencia(item, indexj)" class="item-remove"><i class="fa fa-times-circle"></i></span></li>
                                                </div>
                                                <div v-else class="no-info">
                                                    No se han enlazado jurisprudencias
                                                </div>
                                                <div @click="modalJrs(item, index)" class="nueva-jurisprudencia">
                                                    Agregar jurisprudencia <i class="fa fa-plus-circle"></i>
                                                </div>
                                            </div>
                                            <div class="ca-items-enlaces" v-else-if="whatShow == 'in'">
                                                <div v-if="item.informes.length > 0" class="lists-jurisprudencias">
                                                    <li  class="item-attach" v-for="(j, indexj) in item.informes" :key="j.id+'a'">{{ j.tipo.nombre }} - {{ j.valor_tipo }} <span @click="quitarInforme(item, indexj)" class="item-remove"><i class="fa fa-times-circle"></i></span></li>
                                                </div>
                                                <div v-else class="no-info">
                                                    No se han enlazado informes
                                                </div>
                                                <div @click="modalInformes(item, index)" class="nueva-jurisprudencia">
                                                    Agregar informe <i class="fa fa-plus-circle"></i>
                                                </div>
                                            </div>
                                            <div class="ca-items-enlaces" v-else-if="whatShow == 'an'">
                                                <div v-if="item.analisis.length > 0" class="lists-analisis">
                                                    <template v-for="(a, indexa) in item.analisis">
                                                        <div class="item-attach-analisis d-flex" :key="a.id+'an'">
                                                            <div class="flex-grow-1 w-100">{{ a.titulo }}</div>   
                                                            <div class="buttons-right d-flex">
                                                                <button @click="openAnalisis(a)" class="btn btn-sm btn-success mr-1"><i aria-hidden="true" :class="!a.showAnalisis ? 'fa fa-eye' : 'fa fa-eye-slash'"></i></button>
                                                                <button  @click="deleteAnalisis(a, item.analsis, indexa, item)" class="btn btn-sm btn-danger"><i aria-hidden="true" class="fa fa-trash-o fa-lg"></i></button>
                                                            </div>
                                                        </div>
                                                        <slide-up-down :active="a.showAnalisis" :duration="500" :key="a.id+'content'">
                                                            <div class="contenido-analisis" v-html="a.contenido"></div>
                                                        </slide-up-down>
                                                    </template>
                                                </div>
                                                <div v-else class="no-info">
                                                    No se han enlazado analisis
                                                </div>
                                                <div @click="modalAnalisis(item, index)" class="nueva-jurisprudencia">
                                                    Agregar analisis <i class="fa fa-plus-circle"></i>
                                                </div>
                                            </div>
                                            <div class="ca-items-enlaces" v-else-if="whatShow == 'ad'">
                                                <div v-if="item.adjuntos.length > 0" class="lists-jurisprudencias">
                                                    <li  class="item-attach" v-for="adjunto in item.adjuntos" :key="adjunto.id+'a'">
                                                        {{ adjunto.titulo }} <i>({{ adjunto.extension }})</i>
                                                    <span @click="quitarAdjunto(item, adjunto)" class="item-remove"><i class="fa fa-times-circle"></i></span></li>
                                                </div>
                                                <div v-else class="no-info">
                                                    No se han enlazado adjuntos
                                                </div>
                                                <div @click="modalAdjuntos(item, index)" class="nueva-jurisprudencia">
                                                    Agregar adjunto <i class="fa fa-plus-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </slide-up-down>
            <template>
                <slide-up-down :active="item.showChildren" :duration="500" :key="item.id+'child'">
                    <item-content style="padding-left: 25px;" v-if="item.childrens.length > 0" :items="item.childrens"></item-content>
                </slide-up-down>
            </template>
        </template>
    </div>
</template>
<script>
import Vue from 'vue'
import { RepositoryFactory } from './../../services/RepositoryFactory'
import draggable from 'vuedraggable'
import moment from 'moment'
import ContentItem from './ContenItem'
const ContenidosRepository = RepositoryFactory.get('contenidosAvanzados')
export default {
    name: 'item-content',
    data () {
        return {
            oldValue: '',
            whatShow: ''
        }
    },
      computed: {
        dragOptions() {
        return {
            animation: 0,
            group: "description",
            disabled: false,
            ghostClass: "ghost",
            handle: '.handle'
          }
        }
    },
    props: ['items'],
    components: {
        draggable, ContentItem
    },
    created () {
        // this.eventHub.$on('push_jurisprudencias', (index, items) => {
        //     console.log(index)
        //     this.items[index].jurisprudencias = []
        //     items.map(x => {
        //         this.items[index].jurisprudencias.push(x)
        //     })
        //     $("#jurisprudenciaModal").modal("hide")
        // });
    },
    methods: {
        cancel (item, index) {
            this.items.splice(index, 1)
        },
        saveItem(item, index, parent_id){
            
            if(item.titulo == '') return false

            ContenidosRepository.saveItem({titulo: item.titulo, contenido_id: this.$parent.contenido.id, orden: item.orden}).then(rs => {
                    item.id = rs.data.id
                    item.titulo = rs.data.titulo
                    item.input = false
                    item.orden = rs.data.orden
                    item.showChildren= false
                    Utils.initNoty('El item se guardó con exito', "success");

            }).catch(e => {
                    Utils.initNoty('ocurrio un error al guardar el item', 'error');
            }).finally(f => {
                
            })
        },
        saveSubItem(item, index){
            
            if(item.titulo == '') return false

            ContenidosRepository.saveSubItem({titulo: item.titulo, parent_id: item.parent, orden: item.orden}).then(rs => {
                    item.id = rs.data.id
                    item.titulo = rs.data.titulo
                    item.input = false
                    item.orden = rs.data.orden
                    item.showChildren= false
                    Utils.initNoty('El item se guardó con exito', "success");

            }).catch(e => {
                    Utils.initNoty('ocurrio un error al guardar el item', 'error');
            }).finally(f => {
                
            })
        },
        cancelEdit(item, index){
            item.editing = false
            item.titulo = this.oldValue
            this.oldValue = ''
        },
        editItem (item, index) {
            this.oldValue = item.titulo
            let y = 0
            this.items.forEach(x => {
                x.editing == false 
            })


            Vue.set(item, 'editing', true)

        },
        updateItem(item, index) {
            if(item.titulo == '') {
                Utils.initNoty("El titulo no puede estar vacio!", "error")
                return false
            }

            ContenidosRepository.updateItem({id: item.id, titulo: item.titulo}).then(rs => {
                        if(rs.data.save) {
                            Utils.initNoty('El item se actualizó con exito!', 'success');
                            item.editing = false
                            this.oldValue = ''
                        }
                    }).catch(e => {
                        Utils.initNoty('Ocurrio un error al editar el item', 'error');
                    })
        },
        deleteItem(item, index){

             var n = new Noty({
                text: 'Recuerda que al borrar se eliminará los subíndices, el contenido y los adjuntos. ¿Está seguro(a) que desea eliminar?',
                layout: 'center',
                modal: true,
                theme: "relax",
                buttons: [
                    Noty.button('Sí', 'btn btn-siip-accept', function(){
                       ContenidosRepository.deleteItem(item.id).then(rs => {
                        if(rs.data.delete) {
                            Utils.initNoty('El item se elimino con exito!', 'success');
                            this.items.splice(index,1)
                            n.close();
                        }
                    }).catch(e => {
                        Utils.initNoty('Ocurrio un error al eliminar el item', 'error');
                    })
                    }.bind(this), {id: 'button-success', 'style':'margin-right:10px;'}),

                    Noty.button('No', 'btn btn-siip-cancel', function () {
                        n.close();
                    })
                ]
            }).show();

        },
        addSubItem (item) {
            let x = 0;
            
            item.childrens.forEach(y => {
                if(y.input) x++
            });

            if(x > 0) {
                return false;
            }
            
            item.childrens.push({
                        id: item.id+'tmp',
                        titulo: '',
                        input: true,
                        orden: item.childrens.length > 0 ? item.childrens[item.childrens.length - 1].orden + 1 : 1,
                        nivel: item.nivel + 1,
                        showChildren: false,
                        contenidos:[],
                        jurisprudencias: [],
                        jurisprudencias_count: 0,
                        analisis: [],
                        analisis_count: 0,
                        informes: [],
                        informes_count: 0,
                        adjuntos: [],
                        adjuntos_count: 0,
                        extras: {
                            fecha_publicacion: '',
                            fecha_emision: '',
                            ente_emisor: '1',
                            categoria: '1',
                            subCategoria:'',
                            tipo: '',
                            numero: '',
                            observancia: 'N'
                        },
                        parent: item.id,
                        childrens: []
                    })

            item.showChildren = true
        },
        openItem(item, index) {

            ContenidosRepository.getChilds(item.id).then(rs => {
                if(rs.data.length == 0) {

                    return Utils.initNoty('El item no tiene subindices', 'warning')
                }

                rs.data.forEach(x => {
                    item.childrens.push({
                        id: x.id,
                        titulo: x.titulo,
                        subtitulo: x.subtitulo,
                        input: false,
                        orden: x.orden,
                        nivel: x.depth,
                        showChildren: false,
                        contenidos:[],
                        jurisprudencias: [],
                        jurisprudencias_count: x.jurisprudencias_count,
                        analisis: [],
                        analisis_count: x.analisis_count,
                        informes: [],
                        informes_count: x.informes_count,
                        adjuntos: [],
                        adjuntos_count: x.adjuntos_count,
                         extras: {
                            fecha_publicacion: x.datos !== null ? moment(x.datos.fecha_publicacion).format('DD/MM/YYYY') :'',
                            fecha_emision: x.datos !== null ? moment(x.datos.fecha_emision).format('DD/MM/YYYY') :'',
                            ente_emisor: x.datos !== null ? x.datos.ente_emisor :'',
                            categoria: x.datos !== null ? x.datos.categoria_id : '',
                            subCategoria:x.datos !== null ? x.datos.subcategoria_id : '',
                            tipo: x.datos !== null ? x.datos.tipo_id : '',
                            numero: x.datos !== null ? x.datos.numero : '',
                            observancia: x.datos !== null ? x.datos.observancia : '',
                        },
                        childrens: []
                    })
                })

                item.showChildren = true

            }).finally(f => {
    
            })
            
            
        },
        openContent (item) {
            if(item.showContens) {
                item.showContens = false
                return false
            }

            if(item.extras.categoria_id !== '' || itme.extras.categoria_id !== null) this.loadSubCategorias(item.extras.cabecera_id)

            this.loadContentItems(item)
        },
        showExtras (item) {
            if(item.showExtras) {
                item.showExtras = false
                return false
            }

            Vue.set(item, 'showExtras', true)

            $(`#fp-${item.id}`).datepicker({
                language: 'es',
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
                startDate: -Infinity,
                endDate: new Date()
            }).on("changeDate", () => item.extras.fecha_publicacion = $(`#fp-${item.id}`).val());

            $(`#fe-${item.id}`).datepicker({
                language: 'es',
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
                startDate: -Infinity,
                endDate: new Date()
            }).on("changeDate", () => item.extras.fecha_emision = $(`#fe-${item.id}`).val());
        },
        closeItem(item, index){
            item.childrens = []
            item.showChildren = false
        },
        saveSubtitulo(item){
                ContenidosRepository.saveSubtitulo({cabecera_id: item.id, texto: item.subtitulo}).then(rs => {
                    
                    if(rs.data.save){
                        Utils.initNoty('El subtitutlo se registró con exito', 'success')
                    }

                }).catch(e => {
                        Utils.initNoty('Ocurrio un error inesperado', 'error')
                }).finally(f => {
                        item.extras.saving = false
                })
    
        },
        saveExtras(item) {

            let x = 0

            let extras = Object.entries(item.extras)

            extras.forEach(o => {
                if(o[1] === '' || o[1] === null) {
                    x++
                }
            })

            if(x > 0) {

                Utils.initNoty('No puede dejar datos vacios, verifique e intente de nuevo', 'error')

                return false;
            }
            
            Vue.set(item.extras, 'saving', true)
            ContenidosRepository.saveDatosExtras({cabecera_id: item.id, datos: item.extras}).then(rs => {
                    
                    if(rs.data.save){
                        Utils.initNoty('Los datos se registraron con exito', 'success')
                    }

            }).catch(e => {
                    Utils.initNoty('Ocurrio un error inesperado', 'error')
            }).finally(f => {
                    item.extras.saving = false
            })



        },
        loadSubCategorias (id) {
            this.$parent.$emit('loadSubcategoriasEvent', id)
        },
        loadContentItems(item) {
            item.contenidos = []
            Vue.set(item, 'showing', true)
            ContenidosRepository.loadContentItems(item.id).then(rs => {

                rs.data.forEach(x => {
                     item.contenidos.push({
                            id: x.id, 
                            orden: x.orden,
                            contenido: x.contenido, 
                            tipo: x.tipo,
                            vigencia: x.fecha_vigencia,
                            publicada: x.fecha_publicada,
                            observacion: x.observacion,
                            norma: x.norma !== null ? x.norma : null,
                            childrens: x.children,
                            input: false
                        })
                })

            }).catch(e => {

            }).finally(f => {
                Vue.set(item, 'showContens', true)
                item.showing = false
            })
        },
        ordenarItems(){
             let arr = []
             console.log(this.items)
            this.items.map((item, index) => {
                item.orden = index + 1;
                arr.push({id: item.id, orden: item.orden})
            }) 

            console.log(arr)
        },
        addContentItem(item) {

            item.contenidos.push({
                    id: item.id+'tmpcontet', 
                    orden: item.contenidos.length > 0 ? item.contenidos[item.contenidos.length - 1].orden + 1 : 1,
                    contenido: '', 
                    observacion: null,
                    norma: null,
                    tipo: 0,
                    input: true
                })
        },
        addIncorporar(item) {
            this.eventHub.$emit('openIncorporar', item.contenidos.length)
        },
        consultarJrs(item){
            
            ContenidosRepository.getJurisprudencias(item.id).then(rs => {
                    item.jurisprudencias = []
                    rs.data.items.map(x => {
                       item.jurisprudencias.push(x)
                    })

            })

            this.whatShow = 'jr'
        },
        quitarJurisprudencia (item, index) {

            item.jurisprudencias.splice(index, 1)
            let arr = []
            if(item.jurisprudencias.length > 0) {
                item.jurisprudencias.map(x => {
                    arr.push(x.id)
                })
            }

            ContenidosRepository.addJurisprudencias({items: arr, parent_id: item.id}).then(rs => {
                
                if(rs.data.save) {
                    item.jurisprudencias = []
                    rs.data.items.map(x => {
                       item.jurisprudencias.push(x)
                    })
                    
                }

                item.jurisprudencias_count = rs.data.items.length

            })
        },
        quitarInforme (item, index) {

            item.informes.splice(index, 1)
            let arr = []
            if(item.informes.length > 0) {
                item.informes.map(x => {
                    arr.push(x.id)
                })
            }

            ContenidosRepository.addInformes({items: arr, parent_id: item.id}).then(rs => {
                
                if(rs.data.save) {
                    item.informes = []
                    rs.data.items.map(x => {
                       item.informes.push(x)
                    })
                    
                }

                item.informes_count = rs.data.items.length

            })
        },
        consultarInformes(item){
            ContenidosRepository.getInformes(item.id).then(rs => {
                    item.informes = []
                    rs.data.items.map(x => {
                       item.informes.push(x)
                    })

            })

            this.whatShow = 'in'
        },
        consultarAnalisis(item){
            ContenidosRepository.getAnalisis(item.id).then(rs => {
                    item.analisis = []
                    rs.data.items.map(x => {
                       item.analisis.push(x)
                    })
                
                item.analisis_count =  item.analisis.length

            })

            this.whatShow = 'an'
        },
        consultarAdjuntos(item){

            ContenidosRepository.getAdjuntos(item.id).then(rs => {
                    item.adjuntos = []
                    rs.data.items.map(x => {
                       item.adjuntos.push(x)
                    })

                item.adjuntos_count =  item.adjuntos.length
            })


            this.whatShow = 'ad'
        },
        modalJrs(item, index) {
             $("#jurisprudenciaModal").modal("show")
             this.eventHub.$emit('getJurisprudencias', (item))
        },
        modalInformes(item, index) {
             $("#informesModal").modal("show")
             this.eventHub.$emit('getInformes', (item))
        },
        modalAnalisis(item) {
            $("#analisisModal").modal("show")
             this.eventHub.$emit('SET_ITEM_ANALISIS', (item))
        },
        modalAdjuntos(item) {
            $("#adjuntosModal").modal("show")
             this.eventHub.$emit('SET_ITEM_ADJUNTOS', (item))
        },
        //
        openAnalisis(item) {
            if(item.showAnalisis) {
                item.showAnalisis = false
                return false
            }

            Vue.set(item, 'showAnalisis', true)
        },
        deleteAnalisis (item, analisis, index, parent) {
            let self = this
              var n = new Noty({
                text: 'Esta seguro(a) que desea eliminar analisis?',
                layout: 'center',
                modal: true,
                theme: "relax",
                buttons: [
                    Noty.button('Sí', 'btn btn-siip-accept', function(){
                       ContenidosRepository.deleteAnalisis(item.id).then(rs => {
                        if(rs.data.deleted) {
                                Utils.initNoty('El item se elimino con exito!', 'success');
                                n.close();
                                this.consultarAnalisis(parent)
                            }
                        })
                    }.bind(this), {id: 'button-success', 'style':'margin-right:10px;'}),

                    Noty.button('No', 'btn btn-siip-cancel', function () {
                        n.close();
                    })
                ]
            }).show();
        },
        quitarAdjunto(item, adjunto) {
            
            ContenidosRepository.deleteAdjunto(adjunto.id).then(rs => {
                if(rs.data.deleted) {
                    Utils.initNoty('El archivo se eliminó con exito', 'success')
                    
                }
            }).catch(e => {
                    Utils.initNoty('Ocurrio un error al eliminar el archivo', 'error')
            }).finally(F => {
                this.consultarAdjuntos(item)
            })
        }
    },
    
}
</script>