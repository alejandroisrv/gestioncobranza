<template>
  <div>
    <section class="content-header">
      <h1>Inventario</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active">
                <a href="#fa-icons" data-toggle="tab">Egresos</a>
              </li>
              <li>
                <a href="#glyphicons" data-toggle="tab">Ingresos</a>
              </li>
            </ul>
            <div class="tab-content">
                <contabilidad-list tipo="ingresos" />

            </div>

          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
export default {};
</script>
