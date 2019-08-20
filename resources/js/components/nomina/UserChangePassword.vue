<template>
    <bootstrap-modal ref="changePassword" :need-header="false" :need-footer="true" :size="'small'">
      <div slot="body">
          <div class="box-body">
                  <div class="row">
                      <div class="col-md-12" v-if="loading">
                          <p style="font-size:18px;padding-left:10px;" class="mb-2">Nueva contraseña</p>

                          <span style="padding-left:10px;" class="text-danger d-block" v-if="(noMatch) && (user.confirmNewPassword.length > 2)">Las contraseñas no coinciden</span>
                          <span style="padding-left:10px;" class="text-danger d-block" v-if="error">La contraseña que ha ingresado es incorrecta</span>
                          <span style="padding-left:10px;" class="text-danger d-block" v-if="(errorShort)">La nueva contraseña debe ser mayor a 6 digitos</span>

                          <span @click="cancel" class="close-modal"> &times; </span>
                          <form @submit.prevent="change()">
                            <table class="table col-md-12">
                                <tr>
                                  <td class="td-select">Contraseña actual:</td>
                                </tr>
                                <tr>
                                  <td class="td-select">
                                    <input type="password" class="form-control" v-model="user.password">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="td-select">Nueva contraseña:</td>
                                </tr>
                                <tr>
                                  <td class="td-select">
                                    <input type="password" class="form-control" v-model="user.newPassword">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="td-select">Confirmación:</td>
                                </tr>
                                <tr>
                                  <td class="td-select">
                                    <input type="password" class="form-control" v-model="user.confirmNewPassword">
                                  </td>
                                </tr>
                          </table>
                          <button type="submit" style="display:none" />
                        </form>
                    </div>
              </div>
          </div>
      </div>
      <div slot="footer" class="text-center">
           <button class="btn btn-danger" @click="cancel()"> Cancelar </button>
           <button class="btn btn-primary" @click="change()" :disabled="noMatch || errorShort"> Guardar </button>
      </div>
    </bootstrap-modal>
</template>
<script>
import api from '../../services/api';
export default {
    data(){
        return{
        error:false,
        user:{
          password:'',
          newPassword:'',
          confirmNewPassword:''
        },
        loading:true
        }
    },
    computed:{
      noMatch(){
        if(this.user.newPassword == this.user.confirmNewPassword){
          return false;
        }
        return true;
      },
      errorShort(){
        if(this.user.newPassword.length < 6 || this.user.confirmNewPassword < 6){
          return true;
        }
        return false;
      }
    },
    components:{
        "bootstrap-modal": require("vue2-bootstrap-modal")
    },
    created(){
        this.eventHub.$on('changePassword', () =>{
            this.$refs.changePassword.open();
        });
    },
    methods:{
        cancel(){
          this.$refs.changePassword.close();
        },
        change(){
          api().post('user/change-password',this.user).then(rs =>{
            if(rs.data.response){
              this.$noty.success('Su contraseña se ha cambiado con éxito');
              this.error = false;
              setTimeout(()=>{
                window.location.href='/auth/logout';
              },1200);
              return true;
            }
            this.error = true;
            this.$noty.error('Contraseña incorrecta');
          }).catch(err=>{
            this.$noty.error('Se ha producido un erro al intentar cambiar la contraseña');
          });
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
