<template>
  <div>
    <section class="content-header">
      <h1>
        Dashboard
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="#">
            <i class="fa fa-dashboard"></i> Dashboard
          </a>
        </li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content" v-if="!loading">
      <!-- Default box -->
      <div class="row">
        <div class="col-lg-4 col-xs-6" v-for="(item,idx) in items" :key="idx">
          <div class="small-box" :class="item.color">
            <div class="inner">
              <h3 v-if="item.link !== '/cartera'">{{ item.total }}</h3>
              <h3 v-else >{{ item.total | currency   }}</h3>              
              <p>{{ item.text }}</p>
            </div>
            <div class="icon"> <i :class="item.icon"></i></div>
            <router-link :to="item.link" class="small-box-footer">{{ item.title }} <i class="fa fa-arrow-circle-right"></i> </router-link>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <line-chart :chartdata="chartData" :options="chartOptions"/>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</template>
<script>
import LineChart from './line-chart';
import api from '../../services/api';
export default {
  components:{LineChart},
  data(){
    return {
      items:[{
        total:15,
        loading:true,
        color:'bg-aqua',
        text:'Productos',
        title:'Ver productos',
        link:'/inventario'
      }],
      chartData:{
        labels: ['Lunes', 'Martes','Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'],
        datasets: [
          {
            label: 'Ventas de la semana',
            backgroundColor: '#337ab7',
            data: [40, 39, 10, 40, 39, 80, 40]
          }
        ]
      },
      chartOptions:{responsive: true, maintainAspectRatio: false}
    }
  
  },
  created(){
    this.getData();
  },
  methods:{
      async getData(){
        this.loading = true; 
        const rs = await api().get('/dashboard/all');
        this.items = rs.data.body;
        this.loading = false;   
      }
    }
};
</script>
