
<template>
  <div>
    <section class="content-header">
      <h1>Cartera</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12" v-if="!loading">
          <div class="box box-default">
            <div class="box-body text-right">
              Ruta: {{ rutaName }}
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lista de clientes</h3>
            </div>
            <div class="box-body">
              <div class="col-md-12" v-if="loading"><i class="fa fa-spinner fa-spin loading-spinner"></i></div>
              <template v-else>
                <table v-if=" cartera.data && cartera.data.length > 0 " class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Cliente</th>
                      <th>Abonado</th>
                      <th>Total</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in cartera.data" :key="item.id">
                      <td>{{ item.nombre }} {{ item.apellido  }}  </td>
                      <td>{{ CalcularAbonado(item.pagos_clientes) | currency }}</td>
                      <td>{{ CalcularTotal(item) | currency }}</td>
                      <td>  <button class="btn btn-primary" @click="VerDetalle(item)"><i class="fa fa-eye"></i></button> </td>
                    </tr>
                  </tbody>
                </table>
                <div v-else>
                  <p class="py-4">No se han encontrado informacion</p>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
      <!-- <modal-acuerdo :acuerdo="acuerdo"></modal-acuerdo> -->
    </section>
  </div>
</template>
<script>
import modalAcuerdoPago from "../acuerdos/modalAcuerdo";
import CarteraService from '../../../services/cartera'

export default {
  data() {
    return {
      loading:true,
      cartera:[],
      rutaName:'',

      ruta:0,
      parametros:{
        ruta:'',
        desde:'',
        hasta:''
      }
    };
  },
  watch:{
    "$route.params.ruta"(){
      this.parametros.ruta  = this.$route.params.ruta;
      this.parametros.desde = this.$route.query.desde
      this.parametros.hasta = this.$route.query.hasta
      this.getCartera();
    }
  },
  components: {},
  created() {
      this.parametros.ruta  = this.$route.params.ruta;
      this.parametros.desde = this.$route.query.desde
      this.parametros.hasta = this.$route.query.hasta
    this.getCartera();
  },
  methods: {
    showAll(){
      this.parametros = {ruta: this.$route.params.ruta}
      this.getCartera();
    },
    CalcularAbonado(pagos){
      let abonos = 0;
      pagos.forEach(p => {
        abonos += p.monto;
      });
      return abonos;

    },
    CalcularTotal(item){
      let total = 0;
      let abonos = 0;
      item.ventas.forEach(v=>{
        total += v.total
      })
      abonos = this.CalcularAbonado(item.pagos_clientes);
      return total-abonos;
    },
    async getCartera(){
      this.loading = true;
      const rs = await CarteraService.get(this.parametros);
      this.cartera = rs.data.body;
      this.rutaName = rs.data.ruta.nombre;
      this.loading = false;
    },
    VerDetalle(item) {
      this.eventHub.$emit('VerDetalle',item);
    },
  }
};
</script>

