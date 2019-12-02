require('./bootstrap');
window.Vue = require('vue');
import Vue from 'vue';
import 'babel-polyfill';
import routes from './routes.js';
import main from './components/main.vue'
import navbar from './components/navbar.vue'
import axios from 'axios';
import store from './store';
import can from './can';
import vSelect from 'vue-select'
import VueCurrencyFilter from 'vue-currency-filter'
import Vuetify from 'vuetify'
import VueNoty from 'vuejs-noty'
import Select2 from 'v-select2-component';
import money from 'v-money'

Vue.component('Select2', Select2);
const moment = require('moment')
import 'vue-select/dist/vue-select.css';
import 'vuetify/src/stylus/app.styl';
import 'vuejs-noty/dist/vuejs-noty.css'
import DatePicker from 'vue2-datepicker'
const auth = JSON.parse(localStorage.getItem('auth'));
axios.defaults.headers.common['Authorization'] = 'Bearer ' + auth.api_token;
const eventHub = new Vue() // Single event hub
Vue.mixin({
    data: function() {
        return {
            eventHub: eventHub
        }
    }
})
Vue.mixin(can);
require('moment/locale/es')
Vue.use(require('vue-moment'), {
    moment
})

Vue.use(money, { decimal: ',', thousands: '.',prefix: ' ',suffix: '',precision: 2, masked: false})
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('v-select', vSelect)
Vue.component('date-picker', DatePicker);
Vue.use(VueCurrencyFilter, { symbol: '', thousandsSeparator: '.', fractionCount: 2, fractionSeparator: ',', symbolPosition: 'front', symbolSpacing: true })
Vue.use(Vuetify)
Vue.use(VueNoty, { timeout: 3500, progressBar: true, theme: 'metroui' })

require('./filtros');
const app = new Vue({
    el: '#app',
    store,
    router: routes,
    render: (h) => h(main),
    beforeCreate() {
        store.dispatch('initStore');
    }
})
const nav = new Vue({
    el: '#nav',
    store,
    router: routes,
    render: (h) => h(navbar),
})
