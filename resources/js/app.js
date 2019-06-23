
require('./bootstrap');
window.Vue = require('vue');
import routes from './routes.js';
import main from './components/main.vue'
import navbar from './components/navbar.vue'
const eventHub = new Vue() // Single event hub
Vue.mixin({
    data: function () {
        return {
            eventHub: eventHub
        }
    }
})
import axios from 'axios';
const auth = JSON.parse(document.querySelector('meta[name="user"]').getAttribute('content'));
localStorage.setItem('auth',JSON.stringify(auth));
axios.defaults.headers.common['Authorization'] = 'Bearer '+ auth.api_token;
import store from './store';
import vSelect from 'vue-select'
Vue.component('v-select', vSelect)
import 'vue-select/dist/vue-select.css';

import Vuetify from 'vuetify'
import VueNoty from 'vuejs-noty'
import 'vuetify/src/stylus/app.styl';
import 'vuejs-noty/dist/vuejs-noty.css'
import VuetifyConfirm from 'vuetify-confirm';

Vue.use(Vuetify)
Vue.use(VueNoty, {
    timeout: 3500,
    progressBar: true,
    theme:'metroui'
  })
Vue.use(VuetifyConfirm)
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
