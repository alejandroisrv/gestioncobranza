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
    <section class="content">
      <!-- Default box -->
      <div class="row">
        <div class="col-lg-3 col-xs-6" v-for="(item,idx) in items" :key="idx">
          <div class="small-box" :class="item.color">
            <div class="inner">
              <h3>{{ item.total   }}</h3>
              <p>{{ item.text }}</p>
            </div>
            <div class="icon"> <i class="ion ion-bag"></i></div>
            <router-link :to="item.link" class="small-box-footer">{{ item.title }} <i class="fa fa-arrow-circle-right"></i> </router-link>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</template>
<script>
import api from '../../services/api';
export default {

  data(){
    return {
      items:[{
        total:15,
        color:'bg-aqua',
        text:'Productos',
        title:'Ver productos',
        link:'/inventario'
      }]
    }
  },
  methods:{
      getData(){
        api().get('/dashboard/all');
      }
    }
};
</script>
