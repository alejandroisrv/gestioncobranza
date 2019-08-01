<template>

  <div>
    <section class="content-header">
      <h1>Contabilidad</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body justify-content-end">
              <div class="row justify-content-end">
                <div class="col-md-12 text-right">  
                  <span class="mx-3 my-1" @click="openFiltros()"> Filtros </span>
                  <button class="btn btn-primary my-1" @click="set()"><i class="fa fa-cog"></i> Categorias </button>
                  <button class="btn btn-primary my-1" @click="add()"><i class="fa fa-plus"></i> Nueva Transacción</button>                  
                </div>
              </div>  
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de transacciones</h3> <small class="mx-2" style="cursor:pointer" v-if="busqueda" @click="mostrarTodo()">Mostrar todo</small>
            </div>
          <div class="box-body"> 
            <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
            <template v-else>
               <div class="table-responsive">
                  <table v-if="contabilidad.data && contabilidad.data.length > 0 " class="col-md-12 table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Descripción</th>
                        <th>Operación</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                      </tr>
                    </thead>
                    <tbody>
                      <template v-for="item in contabilidad.data"> 
                        <tr :key="item.id" @click="details = item.id" style="cursor:pointer">
                          <td>{{ item.descripcion }}</td>
                          <td>
                            <span :class="item.type.operacion == 1 ? 'label label-success' : 'label label-danger' ">
                              {{ item.type.operacion | operacionFiltro }} 
                            </span>
                          </td>
                          <td>{{ item.monto | currency }}</td>
                          <td>{{ item.created_at | moment('DD/MM/YYYY') }}</td>
                        </tr>
                        <tr :key="item.id+'details'" v-if="details == item.id">
                          <td colspan="4">
                            <div class="row">
                              <div class="col-md-10" style="font-size:12px!important">
                                {{ item.type.descripcion }}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-10" style="font-size:12px!important">
                                Creador por:
                              </div>
                            </div>
                          </td>
                        </tr>
                      </template>
                    </tbody>
                  </table>
                  <div v-else>
                    <p class="py-4">No se han encontrado productos</p>
                  </div>
                </div>
            </template>
          </div>
        </div>
      </div>
      </div>
    </section>
    <filtro />
    <modal-categoria />
    <add-transacciones />
  </div>
</template>
<script>
import ContabilidadService from '../../services/contabilidad'
import ModalCategoria from './CategoriasModal';
import Filtro from './Filtros';
import AddTransacciones from './AddTransacciones'

export default {
  data(){
    return {
      loading:true,
      details:'',
      busqueda:false,
      contabilidad: [],
      parametros :[]
    }
  },
  components:{ModalCategoria, Filtro,AddTransacciones},
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
    this.getCategorias();
    this.getContabilidad();
    this.eventHub.$on('filtrarContabilidad', parametros => {
      this.parametros = parametros;
      this.busqueda = true;
      this.getContabilidad();
      this.getCategorias();
    });
  },
  methods:{
    mostrarTodo(){
      this.parametros = [];
      this.busqueda = false;
      this.getContabilidad();
    },
    openFiltros(){
      this.eventHub.$emit('openFiltrar');
    },
    set(){
      this.eventHub.$emit('openCategorias');
    },
    add(){
      this.eventHub.$emit('AddTransacciones');
    },
    async getCategorias(){
      const rs = await ContabilidadService.getCategory({});
      this.categorias = rs.data;
    },
    async getContabilidad(){
      this.loading = true;
      const rs = await ContabilidadService.getAll(this.parametros);
      this.contabilidad = rs.data.body;
      this.loading = false;
    }
  },
  filters:{
    operacionFiltro(value){
      switch (value) {
        case 1:
            return 'Abono'
          break;
        case -1:
            return 'Cargo'
          break;
        default:
            return ''
          break;
      }
    }
  }


}
</script>