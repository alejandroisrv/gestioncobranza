<template>
    <bootstrap-modal ref="NuevoMunicipio" :need-header="true" :need-footer="true" :size="'small'">
      <div slot="title"> Nuevo municipio</div>
      <div slot="body">
          <div class="box-body">
                  <div class="row">
                      <div class="col-md-12" v-if="loading">
                          <span style="padding-left:10px;" class="text-danger d-block" v-if="(error)">Debe ingresar al menos 3 caracteres</span>
                          <!-- <span @click="cancel" class="close-modal"> &times; </span> -->
                          <form @submit.prevent="send()">
                            <table class="table col-md-12">
                                <tr>
                                  <td class="td-select">Ingresa el nombre del municipio:</td>
                                </tr>
                                <tr>
                                  <td class="td-select">
                                    <input type="text" class="form-control" v-model="postData.municipio">
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
import api from '../../services/api';
export default {
    data(){
      return{
          error:false,
          postData:{
            municipio:'',
          },
          loading:true
        }
    },
    components:{
        "bootstrap-modal": require("vue2-bootstrap-modal")
    },
    created(){
        this.eventHub.$on('NuevoMunicipio', () =>{
            this.$refs.NuevoMunicipio.open();
        });
    },
    methods:{
        cancel(){
          this.postData.municipio = '';
          this.$refs.NuevoMunicipio.close();
        },
        validateMunicipio(){
          if(this.postData.municipio.length < 3){
            this.error = true;
            return true;
          }
          this.error = false;
          return false;
        },
        send  (){
          if(!(this.validateMunicipio())){
            api().post('municipio',this.postData).then(rs =>{
              if(rs.data.response){
                this.$noty.success('Se ha creado el minicipio con exito');
                this.error = false;
              }
              this.eventHub.$emit("LoadMunicipios");
              this.cancel();
            }).catch(err=>{
              this.$noty.error('Se ha producido un erro al intentar cambiar crear');
            });
          }
        }
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
