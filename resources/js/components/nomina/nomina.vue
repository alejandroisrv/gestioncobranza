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
              <button class="btn btn-default btn-sm" @click="addTrabajador()"> Nuevo Trabajador</button>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de trabajadores</h3>
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
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <div v-else>
                      <p class="py-4">No se han encontrado trabajadores</p>
                    </div>
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
        loading: true
      }
    },
    components: { modalNomina },
    created() {
      this.getNomina()
    },
    methods: {
      async getNomina() {
        const rs = await NominaService.getAll()
        this.nomina = rs.data.body
        this.loading = false
      },
      addTrabajador() {
        this.eventHub.$emit('addTrabajador')
      }
    }
  }

</script>
