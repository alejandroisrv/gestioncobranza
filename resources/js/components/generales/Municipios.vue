<template>
  <div>
    <section class="content-header">
      <h1>Municipios</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-left justify-
            content-end align-items-center">
              <div class="col-md-12 text-right">
                <button class="btn btn-primary" @click="nuevoMunicipio()">Añadir municipio</button>
              </div>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado municipios</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
              <div class="table-responsive" v-else>
                <table v-if="municipios.data && municipios.data.length > 0 " class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Municipio</th>
                      <th>Clientes</th>
                      <th>Sucursales</th>
                      <th>Bodegas</th>
                      <th>Fecha</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in municipios.data" :key="item.id">
                      <td >{{ item.municipio }}</td>
                      <td> {{ item.clientes_count }} </td>
                      <td> {{ item.sucursales_count }} </td>
                      <td> {{ item.bodegas_count }} </td>
                      <td>{{ item.created_at | moment('DD/MM/YYYY') }}</td>
                       <td>
                         <button class="btn btn-primary btn-sm" @click="editMunicipio(item)">
                              <i class="fa fa-edit"></i>
                          </button>
                          <button class="btn btn-danger btn-sm" @click="deleteMunicipio(item.id)" v-if="(item.clientes_count == 0 && item.sucursales_count == 0 && item.bodegas_count == 0)">
                                <i class="fa fa-trash"></i>
                          </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-else>
                  <p class="py-4">No se han creado municipios</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <nuevo-municipio />
  </div>
</template>
<script>
import MunicipioService from '../../services/municipios';
import NuevoMunicipio from './ModalMunicipios';
export default {
  data() {
    return {
      loading:true,
      municipios: "",
    };
  },
  components: { NuevoMunicipio },
  created() {
    this.getMunicipios();
    this.eventHub.$on("LoadMunicipios",() => {
      this.getMunicipios();
    });
  },
  methods: {
    async getMunicipios(){
      this.loading = true;
      const rs = await MunicipioService.getAll();
      this.municipios = rs.data.body;
      this.loading = false;
    },
    nuevoMunicipio(){
      this.eventHub.$emit('NuevoMunicipio',null);
    },
    editMunicipio(item){
      this.eventHub.$emit('NuevoMunicipio',item);
    },
    deleteMunicipio(id){
      var n = new Noty({
      text: '¿Estas seguro que deseas eliminar el municipio?',
      layout:'center',
      modal:true,
      buttons: [
            Noty.button('Cancelar', 'btn btn-danger mx-2 btn-sm', function () {
            n.close();
        }),
        Noty.button('Aceptar', 'btn-sm btn btn-primary', function () {
            MunicipioService.delete(id);
            this.$noty.success('Municipio eliminado');
            this.getMunicipios();
            n.close();
          }.bind(this), {id: 'button1', 'data-status': 'ok'})
        ]
      });
      n.show();
    }
  }
};
</script>
