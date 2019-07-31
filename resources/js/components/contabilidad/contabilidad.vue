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
                <div class="col-md-12">
                  <div class="col-md-5"></div>
                  <span class="btn btn-default col-md-2 mx-1 col-xs-12 my-1">  Filtros </span>
                  <button class="btn btn-primary col-md-2  mx-1 col-xs-12 my-1" @click="set()"><i class="fa fa-cog"></i></button>
                </div>
              </div>  
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de transacciones</h3>
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
                      <tr v-for="item in contabilidad.data" :key="item.id" >
                        <td>{{ item.descripcion }}</td>
                        <td>
                          <span :class="item.type.operacion == 1 ? 'label-success' : 'label-danger' ">
                            {{ item.type.operacion | operacionFiltro }} 
                          </span>
                        </td>
                        <td>{{ item.monto | currency }}</td>
                        <td>{{ item.created_at | moment('DD/MM/YYYY') }}</td>
                      </tr>
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
  </div>
</template>
<script>
import ContabilidadService from '../../services/contabilidad'
import ModalCategoria from './CategoriasModal';
import Filtro from './Filtros';
export default {
  data(){
    return {
      loading:true,
      contabilidad: [],
      categorias : [],
      parametros : { operacion:'' }
    }
  },
  components:{ModalCategoria, Filtro},
  created(){
    this.getCategorias();
    this.getContabilidad({});
    this.eventHub.$on('filtrarContabilidad', parametros => {
      this.parametros = parametros;
      this.getContabilidad();
    });
  },
  methods:{
    openFiltros(){
      this.eventHub.$emit('openFiltrar',this.categorias);
    },
    set(){
      this.eventHub.$emit('openCategorias',this.categorias);
    },
    async getCategorias(){
      const rs = await ContabilidadService.getCategory({});
      this.categorias = rs.data;
      console.log(this.categorias);

    },
    async getContabilidad(){
      const rs = await ContabilidadService.getAll(this.parametros);
      this.contabilidad = rs.data.body;
      this.loading = false;
    }
  },
  filters:{
    operacionFiltro(value){
      switch (value) {
        case 1:
            return 'Ingreso'
          break;
        case -1:
            return 'Egreso'
          break;
        default:
            return ''
          break;
      }
    }
  }


}
</script>