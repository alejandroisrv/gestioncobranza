<template>

  <div>
    <section class="content-header">
      <h1>Nómina</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-right">
              <button class="btn btn-primary" @click="addTrabajador()"><i class="fa fa-plus"></i> Nuevo Trabajador</button>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de trabajadores</h3>
              <div class="box-tools">
                <div class="input-group input-group-sm hidden-xs" style="width: 250px;margin:5px;">
                  <input v-model="parametros.buscar" @keyup.enter="getNomina(1)" class="form-control input-buscar" placeholder="Buscar...">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default input-buscar"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-body">
              <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
              <template v-else>
                  <div class="table-responsive">
                    <table v-if="nomina.data && nomina.data.length > 0 " class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Usuario</th>
                          <th>Nombre</th>
                          <th>Telefono</th>
                          <th>Dirección</th>
                          <th>Rol</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in nomina.data" :key="item.id" >
                          <td>{{ item.email }}</td>
                          <td>{{ item.name}}</td>
                          <td>{{ item.telefono }}</td>
                          <td>{{ item.direccion }}</td>
                          <td>{{ item.rol.name }}</td>
                          <td>
                            <button class="btn btn-primary btn-sm" @click="editarUsuario(item)">
                              <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" @click="eliminarUsuario(item.id)">
                              <i class="fa fa-trash"></i>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <div v-else>
                      <p class="py-4">No se han encontrado trabajadores</p>
                    </div>
                  </div>
                  <div class="box-footer clearfix">
                    <pagination :data="nomina" @pagination-change-page="getNomina"></pagination>
                  </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </section>
    <modal-nomina></modal-nomina>
  </div>

</template>
<script>

  import modalNomina from './modalNomina'
  import NominaService from '../../services/nomina'
  export default {
    data() {
      return {
        nomina: [],
        loading: true,
        parametros:{
          buscar:'',
          page : 1
        }
      }
    },
    components: { modalNomina },
    created() {
      this.getNomina()
      this.eventHub.$on('getNomina',() => this.getNomina());
    },
    methods: {
      async getNomina(page = 1) {
        this.loading = true;
        this.parametros.page = page;
        const rs = await NominaService.getAll(this.parametros);
        this.nomina = rs.data.body
        this.loading = false
      },
      eliminarUsuario(id){
        var n = new Noty({
        text: '¿Estas seguro que deseas eliminar el producto?',
        layout:'center',
        modal:true,
        buttons: [
              Noty.button('Cancelar', 'btn btn-danger mx-2 btn-sm', function () {
              n.close();
          }),
          Noty.button('Aceptar', 'btn-sm btn btn-primary', function () {
              NominaService.delete(id);
              this.$noty.success('Trabajador Eliminado');
              this.getNomina();
              n.close();
            }.bind(this), {id: 'button1', 'data-status': 'ok'})
          ]
        });
        n.show();
      },  
      editarUsuario(item){
        this.eventHub.$emit('addTrabajador',item,true)
      },
      addTrabajador() {
        let trabajador = {
          name: "",
          direccion: "",
          telefono: "",
          cedula: "",
          email: "",
          rol: undefined,
          sucursal:undefined,
          bodega:undefined,
        };

        this.eventHub.$emit('addTrabajador',trabajador,false)
      }
    }
  }

</script>
