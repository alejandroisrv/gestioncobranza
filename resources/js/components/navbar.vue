<template>
  <div>
    <header class="main-header">
      <!-- Logo -->
      <router-link to="/" class="logo">
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
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <router-link to="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="img/user-no.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs"></span>
              </router-link>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="img/user-no.jpg" class="img-circle" alt="User Image">
                  <p>
                    {{ user.name }}
                    <small class="d-block"> {{ user.rol.name }}</small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat" @click="changePassword()">Cambiar contraseña</a>
                  </div>
                  <div class="pull-right">
                    <a href="/auth/logout" class="btn btn-default btn-flat">Cerrar sesión</a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
              <router-link to="/configuracion" data-toggle="control-sidebar">
                <i class="fa fa-gears"></i>
              </router-link>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar" v-if="error">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="img/user-no.jpg" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ user.name}}</p>
            <router-link to="#">
              <i class="fa fa-circle text-success"></i> Online
            </router-link>
          </div>
        </div>
        <!-- search form -->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">Menu Principal</li>
          <li>
            <router-link to="/">
              <i class="fa fa-dashboard"></i>
              <span>Dashboard</span>
            </router-link>
          </li>
          <li v-if="$isVendedor() || $isCobrador()">
            <router-link to="/clientes">
              <i class="fa fa-users"></i>
              <span>Clientes</span>
              <!-- <span class="pull-right-container">
                <small class="label pull-right bg-green">Hot</small>
              </span> -->
            </router-link>
          </li>
          <li class="treeview" v-if="$isAdminBodega()">
            <router-link to="/inventario">
              <i class="fa fa-archive"></i>
              <span>Inventario</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </router-link>
            <ul class="treeview-menu">
              <li>
                <router-link to="/historial">
                  <i class="fa fa-circle-o"></i> Historial
                </router-link>
              </li>
            </ul>
          </li>
          <li class="treeview">
            <router-link to="/ventas" v-if="$isVendedor()">
              <i class="fa fa-bar-chart"></i>
              <span>Ventas</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </router-link>
            <!-- <ul class="treeview-menu">
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
            </ul>-->
          </li>
          <li class="treeview" v-if="$isAdmin()">
            <router-link to="/nomina">
              <i class="fa fa-newspaper-o"></i>
              <span>Nomina</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </router-link>
            <ul class="treeview-menu">
              <li>
                <router-link to="/comisiones">
                  <i class="fa fa-circle-o"></i> Comisiones
                </router-link>
              </li>
            </ul>
          </li>
          <li class="treeview" v-if="$isCobrador()">
            <router-link to="#">
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
                <router-link to="pagos">
                  <i class="fa fa-circle-o"></i> Pagos
                </router-link>
              </li>
              <li>
                <a href="#" @click="selectCartera">
                  <i class="fa fa-circle-o"></i> Cartera
                </a>
              </li>
              <li>
                <router-link to="/cobros">
                  <i class="fa fa-circle-o"></i> Cobros
                </router-link>
              </li>
              <li>
                <router-link to="/morosos">
                  <i class="fa fa-circle-o"></i> Morosos
                </router-link>
              </li>
            </ul>
          </li>
          <li v-if="$isCobrador()">
            <router-link to="/rutas">
              <i class="fa fa-map-o"></i>
              <span>Rutas</span>
            </router-link>
          </li>
          <li v-if="$isAdmin()">
            <router-link to="/contabilidad">
              <i class="fa fa-pie-chart"></i>
              <span>Contabilidad</span>
            </router-link>
          </li>
          <li v-if="$isAdmin()">
            <a href="#" @click="reportes">
              <i class="fa fa-file-excel-o"></i>
              <span>Reportes</span>
            </a>
          </li>
           <li class="treeview" v-if="$isAdmin()">
            <router-link to="#">
              <i class="fa fa-cog"></i><span>Generales</span>
              <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
            </router-link>
            <ul class="treeview-menu">
              <li>
                  <router-link to="/municipios">
                    <i class="fa fa-globe"></i> Municipios
                  </router-link>
              </li>
              <li>
                  <router-link to="/tipo-productos">
                    <i class="fa fa-barcode"></i> Tipo de Productos
                  </router-link>
              </li>
              <li v-if="$isAdmin()">
                <router-link to="/bodegas">
                  <i class="fa fa-home"></i><span>Bodegas</span>
                </router-link>
              </li>
              <li v-if="$isAdmin()">
                <router-link to="/sucursales" >
                  <i class="fa fa-industry"></i><span>Sucursales</span>
                </router-link>
              </li>
            </ul>
          </li>
        </ul>
      </section>
      <!-- /.sidebar -->

    </aside>
    <select-cartera />
    <reporte />
    <user-change />
  </div>
</template>
<script>
import SelectCartera from './cobranza/cartera/SelectCartera';
import Reporte from './reportes/reportes';
import UserChange from './nomina/UserChangePassword';
export default {
  components:{SelectCartera,Reporte,UserChange},
  data() {
    return {
      user: ""
    };
  },
  computed:{
    error(){
      if(this.$route.name == '401' || this.$route.name == '404' ){
        return false;
      }
      return true;
    }
  },
  created() {
    this.user = localStorage.getItem("auth") ? JSON.parse(localStorage.getItem("auth")) : {};
  },
  filters:{
    role(value){
        switch(value){
          case 1:
            return 'Administrador';
          break;
          case 2:
            return 'Administrador de bodegas';
          break;
          case 3:
            return 'Administrador de bodegas';
          break;
          case 4:
            return 'Vendedor';
          break;
        }

    }
  },
  methods:{
    selectCartera(){
      this.eventHub.$emit('SelectCartera');
    },
    reportes(){
      this.eventHub.$emit('Reportes');
    },
    changePassword(){
      this.eventHub.$emit('changePassword');
    }
  }
};
</script>
