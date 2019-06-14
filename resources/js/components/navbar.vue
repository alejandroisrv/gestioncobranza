<template>
  <div>
    <header class="main-header">
      <!-- Logo -->
      <router-link to="plugins/index2" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
          <b>CTG</b>
        </span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
          <b>Gestion de Cobranza</b>
        </span>
      </router-link>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <router-link to="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </router-link>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <li class="dropdown messages-menu">
              <router-link to="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-success">4</span>
              </router-link>
              <ul class="dropdown-menu">
                <li class="header">You have 4 messages</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <li>
                      <!-- start message -->
                      <router-link to="#">
                        <div class="pull-left">
                          <img
                            src="plugins/dist/img/user2-160x160.jpg"
                            class="img-circle"
                            alt="User Image"
                          >
                        </div>
                        <h4>
                          Support Team
                          <small>
                            <i class="fa fa-clock-o"></i> 5 mins
                          </small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </router-link>
                    </li>
                    <!-- end message -->
                  </ul>
                </li>
                <li class="footer">
                  <router-link to="#">See All Messages</router-link>
                </li>
              </ul>
            </li>
            <!-- Notifications: style can be found in dropdown.less -->
            <li class="dropdown notifications-menu">
              <router-link to="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-warning">10</span>
              </router-link>
              <ul class="dropdown-menu">
                <li class="header">You have 10 notifications</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <li>
                      <router-link to="#">
                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                      </router-link>
                    </li>
                  </ul>
                </li>
                <li class="footer">
                  <router-link to="#">View all</router-link>
                </li>
              </ul>
            </li>
            <!-- Tasks: style can be found in dropdown.less -->
            <li class="dropdown tasks-menu">
              <router-link to="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-flag-o"></i>
                <span class="label label-danger">9</span>
              </router-link>
              <ul class="dropdown-menu">
                <li class="header">You have 9 tasks</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <li>
                      <!-- Task item -->
                      <router-link to="#">
                        <h3>
                          Design some buttons
                          <small class="pull-right">20%</small>
                        </h3>
                        <div class="progress xs">
                          <div
                            class="progress-bar progress-bar-aqua"
                            style="width: 20%"
                            role="progressbar"
                            aria-valuenow="20"
                            aria-valuemin="0"
                            aria-valuemax="100"
                          >
                            <span class="sr-only">20% Complete</span>
                          </div>
                        </div>
                      </router-link>
                    </li>
                    <!-- end task item -->
                  </ul>
                </li>
                <li class="footer">
                  <router-link to="#">View all tasks</router-link>
                </li>
              </ul>
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <router-link to="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="plugins/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs">Alexander Pierce</span>
              </router-link>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="plugins/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                  <p>
                    Alexander Pierce - Web Developer
                    <small>Member since Nov. 2012</small>
                  </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                  <div class="row">
                    <div class="col-xs-4 text-center">
                      <router-link to="#">Followers</router-link>
                    </div>
                    <div class="col-xs-4 text-center">
                      <router-link to="#">Sales</router-link>
                    </div>
                    <div class="col-xs-4 text-center">
                      <router-link to="#">Friends</router-link>
                    </div>
                  </div>
                  <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <router-link to="#" class="btn btn-default btn-flat">Profile</router-link>
                  </div>
                  <div class="pull-right">
                    <router-link to="#" class="btn btn-default btn-flat">Sign out</router-link>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
              <router-link to="#" data-toggle="control-sidebar">
                <i class="fa fa-gears"></i>
              </router-link>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="plugins/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>Alexander Pierce</p>
            <router-link to="#">
              <i class="fa fa-circle text-success"></i> Online
            </router-link>
          </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                <i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MAIN NAVIGATION</li>
          <li>
            <router-link to="/">
              <i class="fa fa-dashboard"></i>
              <span>Dashboard</span>
            </router-link>
          </li>
          <li>
            <router-link to="/clientes">
              <i class="fa fa-users"></i>
              <span>Clientes</span>
              <span class="pull-right-container">
                <small class="label pull-right bg-green">Hot</small>
              </span>
            </router-link>
          </li>
          <li>
            <router-link to="/bodegas">
              <i class="fa fa-home"></i>
              <span>Bodegas</span>
            </router-link>
          </li>
                  <li>
            <router-link to="/sucursales">
              <i class="fa fa-home"></i>
              <span>Sucursales</span>
            </router-link>
          </li>
          <li class="treeview">
            <router-link to="/inventario">
              <i class="fa fa-archive"></i>
              <span>Inventario</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </router-link>
            <ul class="treeview-menu">
              <li>
                <router-link to="/devoluciones">
                  <i class="fa fa-circle-o"></i> Devoluciones
                </router-link>
              </li>
            </ul>
          </li>
          <li class="treeview">
            <router-link to="/ventas">
              <i class="fa fa-bar-chart"></i>
              <span>Ventas</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </router-link>
            <ul class="treeview-menu">
              <li>
                <router-link to="/ventas/contado">
                  <i class="fa fa-circle-o"></i> Ventas de contado
                </router-link>
              </li>
              <li>
                <router-link to="/ventas/credito">
                  <i class="fa fa-circle-o"></i> Ventas a credito
                </router-link>
              </li>
            </ul>
          </li>
          <li class="treeview">
            <router-link to="/nomina">
              <i class="fa fa-newspaper-o"></i>
              <span>Nomina</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </router-link>
            <ul class="treeview-menu">
              <li>
                <router-link to="comisiones">
                  <i class="fa fa-circle-o"></i> Comisiones
                </router-link>
              </li>
              <li>
                <router-link to="comisiones/reportes">
                  <i class="fa fa-circle-o"></i> Reportes
                </router-link>
              </li>
            </ul>
          </li>
          <li class="treeview">
            <router-link to="cobrana">
              <i class="fa fa-money"></i>
              <span>Cobranza</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </router-link>
            <ul class="treeview-menu">
              <li>
                <router-link to="acuerdos">
                  <i class="fa fa-circle-o"></i> Acuerdos de Pago
                </router-link>
              </li>
              <li>
                <router-link to="cartera">
                  <i class="fa fa-circle-o"></i> Cartera
                </router-link>
              </li>
              <li>
                <router-link to="cobros">
                  <i class="fa fa-circle-o"></i> Cobros
                </router-link>
              </li>
              <li>
                <router-link to="morosos">
                  <i class="fa fa-circle-o"></i> Morosos
                </router-link>
              </li>
            </ul>
          </li>
          <li>
            <router-link to="/rutas">
              <i class="fa fa-house"></i>
              <span>Rutas</span>
            </router-link>
          </li>
          <li>
            <router-link to="https://adminlte.io/docs">
              <i class="fa fa-book"></i>
              <span>Documentation</span>
            </router-link>
          </li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
  </div>
</template>
<script>
export default {
  data() {
    return {
      user: "25"
    };
  }
};
</script>
