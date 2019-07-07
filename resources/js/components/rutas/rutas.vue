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
              <div class="row">
                <div class="col-md-6 col-xs-12">Filtrar por municipios:</div>
                <div class="col-md-6 text-right col-xs-12">
                  <button class="btn btn-primary" @click="nuevaRuta"> Nueva ruta  </button>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 col-xs-12">
                  <v-select v-model="municipio" :options="municipios" placeholder="Selecciona el municipio"></v-select>
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
                <p class="py-4">No se han encontrado clientes</p>
              </div>
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
      municipio: {id:'all', label:'Todos'}
    };
  },
  components: {
    ModalRuta,RutaDetalle
  },
  watch:{
    municipio(){
      if(this.municipio.id != undefined){
        let query = { municipio: this.municipio.id }
        console.log(query);
        
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
            const rs = await RutaService.getAll(query);
            this.rutas = rs.data.body;
    },
    verRuta(item){
      this.openVerRuta(item);
    },
    editRutas(ruta) {
      this.ruta = ruta;
      this.openModal();
    },
    deleteRuta(id){
      this.$confirm("¿Estas seguro que deseas eliminar esta ruta?").then(
        res => {
          if (res) {
            const rs = RutaService.delete(id);;
            if (rs){
              this.notificacion("Ruta eliminada");
              this.getRutas();
            }else {
              this.$noty.error("Error al intentar suspender cliente");
            }
          }
      })
      
    },

    notificacion(texto) {
      this.$noty.success(texto);
    },
    openVerRuta(ruta){
      console.log("metodo");
      this.eventHub.$emit('rutaVer',ruta);
    },
    nuevaRuta() {
      this.eventHub.$emit("modalRuta");
    }
  }
};
</script>
