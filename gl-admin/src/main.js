import Vue from 'vue'
import App from './App.vue'
import router from './router'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
 import url from '@/utils/config'
 import '../public/css/global.css'
import resource from 'vue-resource'
Vue.use(resource);
Vue.use(ElementUI);

Vue.prototype.$urls=url
Vue.config.productionTip = false

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
