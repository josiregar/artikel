import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'

import axios from 'axios'

Vue.config.productionTip = false

axios.defaults.baseURL = 'http://192.168.1.22:8000/api/'

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
