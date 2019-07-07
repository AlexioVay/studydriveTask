window.Vue = require('vue');

import Paginate from 'vuejs-paginate'
import App from './components/App'
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.use(VueAxios, axios)
Vue.component('paginate', Paginate)

new Vue({
  el: '#app',
  template: '<App/>',
  components: { App },
})