require('../bootstrap');
import Vue from 'vue'


import { BButton, BModal,VBModal  } from 'bootstrap-vue'
Vue.component('b-modal', BModal)
Vue.component('b-button', BButton)



import 'bootstrap-vue/dist/bootstrap-vue.css'



import VueRouter from 'vue-router'
Vue.use(VueRouter)
import {routes} from './routes';
import User from '../helpers/User';
window.User = User
Vue.prototype.$appUrl = window.location.origin
import Notification from '../helpers/Notification';
window.Notification = Notification


import Applicationform from './components/form/form.vue'
Vue.component('Applicationform', Applicationform);
import ApplicationformwitnNid from './components/form/formwithNid.vue'
Vue.component('ApplicationformwitnNid', ApplicationformwitnNid);


import Applicationformprepay from './components/form_pre_pay/form.vue'
Vue.component('Applicationformprepay', Applicationformprepay);
import ApplicationformwitnNidprepay from './components/form_pre_pay/formwithNid.vue'
Vue.component('ApplicationformwitnNidprepay', ApplicationformwitnNidprepay);

import loader from "vue-ui-preloader";

Vue.use(loader);

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
