<template>
  <div>
    <section class="content-header">

    </section>
    <section class="content">
        <div class="error-content" style="text-align: center;margin-left: -238px;">
          <h1  class="headline text-yellow">
            <i class="fa fa-warning text-yellow mx-2" style="font-size:40px!important"></i>
          </h1>
          <h1>PÁGINA NO ENCONTRADA.</h1>
          <h3 style="font-weight:300;">
            No hemos podido encontrar la pagina que buscas.
          </h3>
          <p>
            Intenta regresar a la pagina
            <router-link to="/">principal</router-link>.
          </p>
        </div>
        <!-- /.error-content -->
    </section>
  </div>
</template>
<script>
export default {};
</script>
<style>
.main-footer {
  margin-left:-239px;
  padding-left:239px;
}
</style>
