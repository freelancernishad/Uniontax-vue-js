require('../bootstrap');
import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Import Bootstrap and BootstrapVue CSS files (order is important)
// import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

import VueRouter from 'vue-router'
Vue.use(VueRouter)
import {routes} from './routes';
import User from '../helpers/User';
window.User = User
Vue.prototype.$appUrl = window.location.origin
import Notification from '../helpers/Notification';
window.Notification = Notification
import UnionSelect from './components/layouts/unonselect.vue'
Vue.component('UnionSelect', UnionSelect);

import SideBar from './components/layouts/SideBar.vue'
Vue.component('SideBar', SideBar);
import store from '../store'
window.Reload = new Vue();
import Swal from 'sweetalert2'
window.Swal = Swal;



import VeeValidate from 'vee-validate'
Vue.use(VeeValidate, {
  // This is the default
  inject: true,
  // Important to name this something other than 'fields'
  fieldsBagName: 'veeFields',
  // This is not required but avoids possible naming conflicts
  errorBagName: 'veeErrors'
})


const router = new VueRouter({
  routes,
  mode: 'history'
})
const app = new Vue({
    el: '#app',
    router,
    store
});
