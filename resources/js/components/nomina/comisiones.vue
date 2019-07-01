<template>

  <div>
    <section class="content-header">
      <h1>Comisiones</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-left">
              Filtrar: 
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de comisiones generadas</h3>
              <div class="box-tools">
                <div class="input-group input-group-sm mt-2" style="width: 250px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
              <template v-else>
              <table v-if="comisiones.data && comisiones.data.length > 0 " class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Vendedor</th>
                    <th>Venta</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in comisiones.data" :key="item.id" >
                    <td v-if="item.vendedor!=null">{{ item.vendedor.name }}</td>
                    <td>{{ item.venta.id }}</td>
                    <td>{{ item.monto}}</td>
                    <td>{{ item.estado }} </td>
                    <td>{{ item.created_at }}</td>
                    <td>
                      <button class="btn btn-default btn-sm" @click="verProducto(item)">
                            <i class="fa fa-eye"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div v-else>
                <p class="py-4">No se han generado comisiones</p>
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
import ComisionService from '../../services/comisiones'
export default {

  data(){
    return {
      comisiones:[],
      loading:true,
    }

  },
  created(){
    this.getComisiones();

  },
  methods:{

    async getComisiones(){
      const rs = await ComisionService.getAll();
      this.comisiones =rs.data.body;
      this.loading=false;
    },
    async pagarComision(item){
      const rs = await ComisionService.pay(item.id);


    }
  }
}
</script>
