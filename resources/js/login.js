require('./bootstrap');
window.Vue = require('vue');
import Vue from 'vue';
import Login from './components/login';

const app = new Vue({
    el: "#login",
    render: (h) => h(Login),

});