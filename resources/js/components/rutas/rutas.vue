<template>
  <div>
    <section class="content-header">
      <h1>Rutas</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-left align-items-center">
              <div class="row align-self-center">
                <div class="col-md-6 text-left col-sm-12 col-xs-12 d-flex">
                  <div class="col-md-4 pr-0 col-xs-12 col-sm-12 align-self-center">
                     Filtrar por municipios:
                  </div>
                  <v-select class="pl-0 col-md-8 col-xs-12 col-sm-12" v-model="municipio" :options="municipios" placeholder="Selecciona el municipio"></v-select>
                </div>
                <div class="col-md-6 text-right col-xs-12 col-sm-12">
                  <button class="btn btn-primary" @click="nuevaRuta"> Nueva ruta  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de rutas </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
              <template  v-else>
                <div class="table-responsive">
                  <table v-if="rutas.data && rutas.data.length > 0 " class="col-md-12 table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th> Nombre</th>
                      <th> Municipio</th>
                      <th> Fecha creación </th>
                      <th> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in rutas.data" :key="item.id">
                      <td>{{ item.nombre }}</td>
                      <td>{{ item.municipio.municipio }}</td>
                      <td >{{ item.created_at }}</td>
                      <td class="text-right">
                        <button class="btn btn-default btn-sm" @click="verRuta(item)">
                          <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-primary btn-sm" @click="editRuta(item)">
                          <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" @click="deleteRuta(item.id)">
                          <i class="fa fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table> 

                <div v-else>
                  <p class="py-4">No se han encontrado rutas</p>
                </div>
                </div>
      
              </template>
            
         
            </div>
            <!-- /.box-body -->
          
          </div>
        </div>
      </div>
      <modal-ruta />
      <ruta-detalle />
    </section>
  </div>
</template>
<script>
import ModalRuta from "./modalRutas";
import RutaDetalle from './ruta';
import { mapGetters, mapActions } from "vuex";
import RutaService from '../../services/rutas';
export default {
  data() {
    return {
      rutas:{
          data:[{}]
      },
      municipio:undefined,
      loading:true,
    };
  },
  components: {
    ModalRuta,RutaDetalle
  },
  watch:{
    municipio(){
      if(this.municipio.id != undefined){
        let query = { municipio: this.municipio.id }
        this.getRutas(query);
      }
    }
  },
  computed: {
    ...mapGetters({
      municipios:'municipios/municipiosFormat'
     })
  },
  created() {
    this.getRutas();
    this.eventHub.$on("sendRuta", rs => {
      this.getRutas();
    });
  },
  methods: {
    ...mapActions({ }),
      async getRutas(query){
            this.loading = true;
            const rs = await RutaService.getAll(query);
            this.rutas = rs.data.body;
            this.loading = false;
    },
    nuevaRuta() {
      this.eventHub.$emit("modalRuta");
    },
    verRuta(ruta){
      this.eventHub.$emit('rutaVer',ruta);
    },
    editRuta(ruta) {
        this.eventHub.$emit("modalRuta",ruta);
    },
    deleteRuta(id){
       var n = new Noty({
        text: "¿Estas seguro que deseas eliminar esta ruta?",
        layout:'center',
        modal:true,
        buttons: [
              Noty.button('Cancelar', 'btn btn-danger mx-2 btn-sm', function () {
              n.close();
          }),
          Noty.button('Aceptar', 'btn-sm btn btn-primary', function () {
              RutaService.delete(id);;
              this.$noty.success('Ruta Eliminado');
              this.getRutas();
              n.close();
            }.bind(this), {id: 'button1', 'data-status': 'ok'})
          ]
        });
        n.show();  
    },
    notificacion(texto) {
      this.$noty.success(texto);
    },
  }
};
</script>
