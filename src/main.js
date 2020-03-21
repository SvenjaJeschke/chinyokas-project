import Vue from 'vue';
import App from './App.vue';
import router from './router';
import Buefy from 'buefy';
import 'buefy/dist/buefy.css';
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueDayjs from 'vue-dayjs-plugin';
 
Vue.use(VueAxios, axios)
Vue.use(VueDayjs);
Vue.use(Buefy);

Vue.config.productionTip = false;

new Vue({
  render: h => h(App),
  router
}).$mount('#app');
