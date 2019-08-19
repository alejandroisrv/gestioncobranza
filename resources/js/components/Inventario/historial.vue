<template>
  <div>
    <section class="content-header">
      <h1>Movimientos del inventario</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body justify-content-end">
              <div class="row justify-content-end">
                <div class="col-md-12">
                  <div class="col-md-5 text-left"></div>
                  <span class="text-right col-md-7" @click="Filtros">Filtros </span>
                </div>
              </div>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de movimientos</h3>
            </div>
            <div class="box-body">
              <div class="col-md-12" v-if="loading">
                <i class="fa fa-spinner fa-spin loading-spinner"></i>
              </div>
              <template v-else>
                <div class="table-responsive">
                <table v-if="historial.data && historial.data.length > 0 " class="col-md-12 table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Operación</th>
                        <th>Descripcion</th>
                        <th>Fecha</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr v-for="h in historial.data" :key="h.id">
                            <td>{{ h.producto.nombre }} </td>
                            <td>{{ h.cantidad }} </td>
                            <td><span :class=" h.operacion == 1 ? 'label label-success' : 'label label-danger' "> {{ h.operacion | operacionFiltro }} </span>  </td>
                            <td>{{ h.descripcion  }} </td>
                            <td>{{ h.created_at | moment('HH:mm DD/MM/YYYY') }}</td>
                        </tr>
                    </tbody>
                </table>
                </div>
              </template>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>


import MovimientoService from '../../services/movimientos';

export default {
    data(){
        return {
            loading:true,
            filtrando:false,
            historial:[]
        }
    },
    created(){
        this.getHistorial({});
        this.eventHub.$on('SendFiltro',parametros =>{
          this.getHistorial(parametros);
        });
    },
    methods:{
      Filtros(){
          this.eventHub.$emit('openFiltrar');
      },
        async getHistorial(parametros){
            this.loading= true;
            const rs = await MovimientoService.get(parametros);
            this.historial = rs.data.body;
            this.loading = false;
        }
    },
    filters:{
      operacionFiltro(value){
        if(value==-1){
          return 'Salida';
        }else{
          return 'Entrada';
        }

      }
    }

};
</script>
