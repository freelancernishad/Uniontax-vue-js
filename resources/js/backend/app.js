import Vue from 'vue'
require('../bootstrap');


// require('../bootstrap');
// import "datatables.net-dt/js/dataTables.dataTables";
// import 'datatables.net-buttons-bs4'
// // import 'datatables.net-buttons'


// Vue.use(moment)
// import { Datetime } from 'vue-datetime';
// import 'vue-datetime/dist/vue-datetime.css'
// Vue.component('datetime', Datetime);







// Vue.use(require('vue-moment'));

// require( 'jszip' );
// require( 'pdfmake' );
// require( 'semantic-ui-button' );
// require( 'datatables.net-autofill-dt' );

// require( 'datatables.net-dt' );
// require( 'datatables.net-buttons-dt' );
// require( 'datatables.net-bs5' );
// require( 'datatables.net-buttons-bs5' );
// require( 'datatables.net-bs4' );
// require( 'datatables.net-buttons-bs4' );

// require( 'datatables.net-buttons/js/buttons.colVis.js' );
// require( 'datatables.net-buttons/js/buttons.html5.js' );
// require( 'datatables.net-buttons/js/buttons.print.js' );

// require( 'datatables.net-buttons/js/buttons.colVis.js' )();
// require( 'datatables.net-buttons/js/buttons.html5.js' )();
// require( 'datatables.net-buttons/js/buttons.print.js' )();


// require( 'datatables.net-colreorder-dt' );
// require( 'datatables.net-datetime' );
// require( 'datatables.net-fixedcolumns-dt' );
// require( 'datatables.net-fixedheader-dt' );
// require( 'datatables.net-keytable-dt' );
// require( 'datatables.net-responsive-dt' );
// require( 'datatables.net-rowgroup-dt' );
// require( 'datatables.net-rowreorder-dt' );
// require( 'datatables.net-scroller-dt' );
// require( 'datatables.net-searchbuilder-dt' );
// require( 'datatables.net-searchpanes-dt' );
// require( 'datatables.net-select-dt' );
// require( 'datatables.net-staterestore-dt' );


// import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// // Import Bootstrap and BootstrapVue CSS files (order is important)
// // import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'

// // Make BootstrapVue available throughout your project
// Vue.use(BootstrapVue)
// // Optionally install the BootstrapVue icon components plugin
// Vue.use(IconsPlugin)


import { BButton, BImg, BModal,VBModal  } from 'bootstrap-vue'
Vue.component('b-modal', BModal)
Vue.component('b-button', BButton)
Vue.component('b-img', BImg)



import Swal from 'sweetalert2'
window.Swal = Swal;

import VueRouter from 'vue-router'
Vue.use(VueRouter)
import {routes} from './routes';

import store from '../store'

import tablecom from '../table.vue'
Vue.component('TableComponent', tablecom);

import approvesonod from './components/sonod/approvesonod.vue'
Vue.component('Approvesonod', approvesonod);

import approvetrade from './components/sonod/approvetrade.vue'
Vue.component('Approvetrade', approvetrade);

import approveprottoyon from './components/sonod/approveprottoyon.vue'
Vue.component('Approveprottoyon', approveprottoyon);

Vue.prototype.$localStorage = localStorage;

import loader from "vue-ui-preloader";

Vue.use(loader);


window.Reload = new Vue();
const router = new VueRouter({
  routes,
  mode: 'history'
})
const app = new Vue({
    el: '#app',
    router,
    store
});


