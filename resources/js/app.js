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
const moment = require('moment')
import 'vue-select/dist/vue-select.css';
import 'vuetify/src/stylus/app.styl';
import 'vuejs-noty/dist/vuejs-noty.css'
import VuetifyConfirm from 'vuetify-confirm';
import DatePicker from 'vue2-datepicker'
const auth = JSON.parse(document.querySelector('meta[name="user"]').getAttribute('content'));
localStorage.setItem('auth', JSON.stringify(auth));
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
Vue.component('v-select', vSelect)
Vue.component('date-picker', DatePicker);
Vue.use(VueCurrencyFilter, { symbol: '',thousandsSeparator: '.', fractionCount: 2,fractionSeparator: ',',symbolPosition: 'front',symbolSpacing: true })
Vue.use(Vuetify)
Vue.use(VueNoty, { timeout: 3500, rogressBar: true, theme: 'metroui' })
Vue.use(VuetifyConfirm, { buttonTrueText: 'Aceptar', buttonFalseText: 'Cancelar', color: 'warning', icon: 'warning',title: 'Warning',width: 350,property: '$confirm'})
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
