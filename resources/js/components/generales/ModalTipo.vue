<template>
    <bootstrap-modal ref="NuevoTipo" :need-header="true" :need-footer="true" :size="'small'">
      <div slot="title"> Nuevo tipo de producto</div>
      <div slot="body">
          <div class="box-body" style="padding-top: 0px;">
                  <div class="row">
                      <div class="col-md-12" v-if="loading">
                          <span style="padding-left:10px;" class="text-danger d-block" v-if="(error)">Debe ingresar al menos 3 caracteres</span>
                          <!-- <span @click="cancel" class="close-modal"> &times; </span> -->
                          <form @submit.prevent="send()">
                            <table class="table col-md-12">
                                <tr>
                                  <td class="td-select">Ingresa el tipo de producto:</td>
                                </tr>
                                <tr>
                                  <td class="td-select">
                                    <input type="text" class="form-control" v-model="postData.tipo">
                                  </td>
                                </tr>
                          </table>
                          <button type="submit" style="display:none" />
                        </form>
                    </div>
              </div>
          </div>
      </div>
      <div slot="footer" class="text-right">
           <button class="btn btn-danger my-2" @click="cancel()"> Cancelar </button>
           <button class="btn btn-primary my-2" @click="send()" :disabled="error"> Guardar </button>
      </div>
    </bootstrap-modal>
</template>
<script>
import ProductoService from '../../services/productos';

export default {
    data(){
      return{
          error:false,
          postData:{
            tipo:'',
          },
          loading:true
        }
    },
    components:{
        "bootstrap-modal": require("vue2-bootstrap-modal")
    },
    created(){
        this.eventHub.$on('NuevoTipo', tipo => {
            this.editando = false
            this.postData.tipo = '';
            if(tipo !== null ){
              this.postData = tipo;
              this.postData.tipo = tipo.label;
              this.editando = true;
            }
            this.$refs.NuevoTipo.open();
        });
    },
    methods:{
        cancel(){
          this.postData.tipo = '';
          this.$refs.NuevoTipo.close();
        },
        validateTipo(){
          if(this.postData.tipo.length < 3){
            this.error = true;
            return true;
          }
          this.error = false;
          return false;
        },
        async send(){
          if(!(this.validateTipo())){
            try {
              const rs = (!this.editando) ? await ProductoService.addTipos(this.postData) : await ProductoService.editTipos(this.postData) ;
              if(rs.data.response){
                this.$noty.success((!this.editando) ? 'Se ha creado el tipo de producto con exito': 'Se ha editado el tipo de producto con exito');
                this.error = false;
              }
              this.eventHub.$emit("LoadTipos");
              this.cancel();
            } catch (err) {
              this.$noty.error('Se ha producido un error');
            }
          }
        },
    },

}
</script>
<style>
tr{
    max-width: 100px !important;
}


.close-modal{
  position: absolute;
  top: -15px;
  right: 10px;
  font-size: 20px;
  cursor: pointer;
}

.td-label{
    -align: right;
}
.td-select{
    min-width: 220px;
    max-width: 220px;
}

.td-label-sm{
    max-width: 50px;
    min-width: 50px;
    text-align: right;
}

.td-select-sm{
    max-width: 50px;
    min-width: 50px;
}

.mx-input-append {
    height: inherit !important;
}
.mx-input-wrapper {
    max-width: 235px;
    min-width: 235px;
    width: 233px;
}

@media (min-width: 768px){
    .modal-sm {
        width: 400px;
    }
}

</style>
