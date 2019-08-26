<template>
    <div class="login-box" >
        <div class="login-logo">
            <a href="/">Creditos<b>Torres</b></a>
        </div>
    <!-- /.login-logo -->
        <div class="login-box-body">
            <p style="font-size:16px;text-align:center">Iniciar sesión </p>
            <form @submit.prevent="login()" autocomplete="off">
                <p class="text-danger" v-if="error!=''" style="text-align:center;font-weight:600;">{{ error }}</p>
                <div class="form-group has-feedback mb-1" style="margin-bottom:8px;">
                    <input v-model="credenciales.email" class="form-control" placeholder="Username" name="email">
                    <span class="invalid-feedback" role="alert" v-if="validations.email">
                        <p class="text-danger validation-faild"> Introduce tu usuario  </p>
                    </span>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" v-model="credenciales.password" class="form-control" placeholder="Password" name="password">
                    <span class="invalid-feedback" role="alert" v-if="validations.password">
                        <p class="text-danger validation-faild"> Introduce tu contraseña  </p>
                    </span>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import Noty from 'noty'
export default {
    data(){
        return {
            credenciales:{
                email:'',
                password:''
            },
            validations:{
                password:false,
                email:false,
            },
            error:''
        }
    },
    methods:{
        login(){
            if(this.validationEmail() && this.validationPassword()){
                axios.post('/login',this.credenciales).then(rs=>{
                    if(rs.data.response){
                        localStorage.setItem('auth', JSON.stringify(rs.data.user));
                        window.location.href="/";
                    }else {
                        this.error = rs.data.error;
                    }
                })
            }
        },
        validationEmail(){
            if(this.credenciales.email == ''){
                this.validations.email = true;
                return false;
            }
            return true;
        },
        validationPassword(){
            if(this.credenciales.password == ''){
                this.validations.password = true;
                return false;
            }
            return true;
        }

    }


}
</script>
<style>
.validation-faild{
    margin-top:6px;
    margin-left:1px;
    font-weight:600;
    font-size:13px;
    margin-bottom:0px;
} 
.error{
    display: block;
    margin: 10px;
    margin: 0 20px 15px 20px !important;
    color: red !important;
    font-weight: 400;
}
</style>