<template>

        <bootstrap-modal ref="verCobro" :need-header="true" :need-footer="true" :size="'medium'">
            <div slot="title">Detalle de la cobro </div>
            <div slot="body">
                 <div class="box-body" v-if="cobro!=''">
                     <div class="row">
                        <div class="col-md-12">
                            <p style="font-size:18px;" class="mb-1"> Jornada de Cobro </p>
                            <p class="col-md-6 px-0 text-muted">  Número de clientes {{ ruta.items.length }} </p>
                            <p class="col-md-6 text-muted">Municipio {{ruta.municipio.municipio  }}   </p>
                            <p class="col-md-6 px-0 text-muted">  Número de clientes {{ ruta.items.length }} </p>
                            <p class="col-md-6 text-muted">Municipio {{ruta.municipio.municipio  }}   </p>
                        </div>
                     </div>
                     <div class="row">
                         <div class="col-md-12">
                             <p style="font-size:16px;" class="mb-1"> Orden de la ruta </p>
                             <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Cliente</th>
                                        <th> Dirección</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in ruta.items" :key="item.id">
                                        <th scope="row">{{item.orden}}</th>
                                        <td>{{item.cliente.nombre}} {{item.cliente.apellido}}</td>
                                        <td>{{item.cliente.direccion}}</td>
                                    </tr>
                                </tbody>
                            </table>
                         </div>
                     </div>
                </div>
            </div>
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Condensed Full Width Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed">
                <tbody><tr>
                  
                  <th>Task</th>
                  <th>Progress</th>
                  <th style="width: 40px">Label</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>Update software</td>
                  <td>
                    <div class="progress progress-xs">
                      <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-red">55%</span></td>
                </tr>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
            <div slot="footer">

                <button class="btn btn-primary" @click="close">Continuar</button>
            </div>
        </bootstrap-modal>

</template>
<script>
export default {
    
    data(){
        return {
            cobro:''
        }
    },
    components: {
        "bootstrap-modal": require("vue2-bootstrap-modal")
    },
    created(){
        this.eventHub.$on('verCobro', cobro =>{
            this.cobro = cobro
            this.open();
        });
    },
    methods:{
        open(){
            this.$refs.verCobro.open();
        },
        close(){
            this.$refs.verCobro.close();
        },

    }


}
</script>
