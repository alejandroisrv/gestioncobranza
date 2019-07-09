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
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ productos.total   }}</h3>
              <p>Productos</p>
            </div>
            <div class="icon"> <i class="ion ion-bag"></i></div>
            <router-link to="/inventario" class="small-box-footer">Ver inventario <i class="fa fa-arrow-circle-right"></i> </router-link>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <div class="row"></div>
    </section>
    <!-- /.content -->
  </div>
</template>
<script>
export default {};
</script>
