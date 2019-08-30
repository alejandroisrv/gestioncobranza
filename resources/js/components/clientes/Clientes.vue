<template>
  <div>
    <section class="content-header">
      <h1>Clientes</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body" style="line-height:34px;">
              <div class="col-md-1" style="padding-left:20px;">Municipio:</div>
              <div class="col-md-3 p-0"><v-select v-model="parametros.municipio" :options="minicipios" placeholder="Selecciona el municipio" /></div>
              <div class="col-md-8 text-right">
                <button class="btn btn-primary" @click="nuevoCliente">
                  <i class="fa fa-plus mr-2"></i> Nuevo cliente
                </button>
              </div>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de Clientes</h3>
               <div class="box-tools">
                <div class="input-group input-group-sm hidden-xs" style="width: 250px;margin:5px;">
                  <input v-model="parametros.buscar" @keyup.enter="getClientes()" class="form-control input-buscar" placeholder="Buscar...">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default input-buscar"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
              <template v-else>
                <table v-if=" clientes.data && clientes.data.length > 0 " class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Código</th>
                      <th>Nombre</th>
                      <th>Dirección</th>
                      <th>Telefono</th>
                      <th>E-mail</th>
                      <th>Ruta</th>
                      <th></th>

                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in clientes.data" :key="item.id" :style="item.ruta == 0 ? 'border: 3px solid #ff00004d':''">
                      <th>{{ item.cod }}  </th>
                      <td>{{ item.nombre }}</td>
                      <td>{{ item.direccion }}</td>
                      <td>{{ item.telefono}}</td>
                      <td>{{ item.email }}</td>
                      <td class="font-weight-bold" v-if="item.ruta != 0">{{ item.ruta_items.ruta.nombre }}</td>
                      <td class="font-weight-bold" v-else>Sin ruta</td>
                      <td>
                        <button class="btn btn-default btn-sm" @click="verCliente(item)">
                          <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-primary btn-sm" @click="editarCliente(item)">
                          <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" @click="eliminarCliente(item.id)">
                          <i class="fa fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-else>
                  <p class="py-4">No se han encontrado clientes</p>
                </div>
                 <div class="box-footer clearfix">
                    <pagination :data="clientes" @pagination-change-page="getClientes"></pagination>
                </div>
              </template>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <modal-cliente :titulo="tituloModal" :url="urlModal" :notificacion="notificacionModal"></modal-cliente>
      <cliente></cliente>
    </section>
  </div>
</template>
<script>
import ClienteService from '../../services/clientes';
import modalCliente from "./modalCliente";
import cliente from "./Cliente";
import { mapGetters } from 'vuex';
export default {
  data() {
    return {
      loading:true,
      clienteModal: "",
      tituloModal: "",
      urlModal: "",
      clientes: "",
      notificacionModal: "",
      parametros:{
        municipio:'',
        buscar:'',
      }
    };
  },
  computed:{
    ...mapGetters({minicipios:'municipios/municipiosFormat'})
  },
  components: {
    modalCliente,cliente
  },
  created() {
    this.getClientes();
    this.eventHub.$on("sendCliente", rs => {
      this.getClientes();
    });
  },
  watch:{
    "parametros.municipio"(){
      this.getClientes();
    }
  },
  methods: {
    async getClientes(page = 1) {
      this.loading = true;
      
      let parametros = {
        municipio: (this.parametros.municipio.id) ? this.parametros.municipio.id :'',
        buscar: this.parametros.buscar,
        page:page
      }

      const rs = await ClienteService.getAll(parametros);
      this.clientes= rs.data.body;
      this.loading = false;

    },
    nuevoCliente() {
     
      this.clienteModal = {
        nombre: "",
        apellido: "",
        direccion: "",
        cedula: "",
        minicipio: "0",
        telefono: "",
        email: ""
      };
      this.tituloModal = "Nuevo cliente";
      this.urlModal = "/api/cliente/add";
      this.notificacionModal = "Cliente agregado con exito agregado con éxito!";
      this.openModal(this.clienteModal);
    },
    editarCliente(cliente) {
      this.clienteModal = cliente;
      this.tituloModal = "Editar cliente";
      this.urlModal = "/api/clientes/update/" + cliente.id;
      this.notificacionModal = "El cliente ha sido editado!";
      this.openModal(cliente);
    },
    verCliente(cliente) {
      this.eventHub.$emit('verCliente',cliente);
    },
    eliminarCliente(id) {
      var n = new Noty({
      text: '¿Estas seguro que deseas eliminar el cliente?',
      layout:'center',
      modal:true,
      buttons: [
        Noty.button('Cancelar', 'btn btn-danger mx-2 btn-sm', function () {
            n.close();
        }),
        Noty.button('Aceptar', 'btn-sm btn btn-primary', function () {
            axios.get(`/api/cliente/delete/${id}`).then(rs=>{
              this.getClientes();
              this.notificacion("Cliente Eliminado");
            }).catch(err => this.$noty.error('Se ha producido un error al intentar eliminar el cliente'));
            n.close();
        }.bind(this), {id: 'button1', 'data-status': 'ok'})
        ]
      });
      n.show();
    },
    notificacion(texto) {
      this.$noty.success(texto);
    },
    openModal(cliente) {
      this.eventHub.$emit("openModal",cliente);
    }
  }
};
</script>

