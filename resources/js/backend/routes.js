let adminlayout = require('./components/layouts/adminlayout.vue').default;
let blanklayout = require('./components/layouts/blanklayout.vue').default;



// Auth Components

let logout = require('./components/auth/logout.vue').default;

let home = require('./components/home.vue').default;
let profile = require('./components/profile.vue').default;

let sonodlist = require('./components/sonodList/list.vue').default;

let sonodlistedit = require('./components/sonodList/form.vue').default;

let sonod = require('./components/sonod/index.vue').default;
let sonodedit = require('./components/sonod/form.vue').default;
let sonodview = require('./components/sonod/view.vue').default;

let sonodapprove = require('./components/sonod/approve.vue').default;
let approvesonod = require('./components/sonod/approvesonod.vue').default;
let approvetrade = require('./components/sonod/approvetrade.vue').default;

let Tags = require('./components/Tags/index.vue').default;
let role = require('./components/assignRole.vue').default;

let index = require('./components/vuex/index.vue').default;

let PageNotFound = require('./components/404.vue').default;


let prefix = '/dashboard'
export const routes = [

  //Auth Routes

  { path: `${prefix}/logout`, component: logout, name:'logout',meta: { layout: blanklayout } },

  { path:  `${prefix}`, component: home, name:'Dashboard',meta: { layout: adminlayout } },
  { path:  `${prefix}/profile`, component: profile, name:'profile',meta: { layout: adminlayout } },

  { path:  `${prefix}/sonod/list`, component: sonodlist, name:'sonodlist',meta: { layout: adminlayout } },
  { path:  `${prefix}/sonod/list/add`, component: sonodlistedit, name:'sonodlistadd',meta: { layout: adminlayout } },
  { path:  `${prefix}/sonod/list/edit/:id`, component: sonodlistedit, name:'sonodlistedit',meta: { layout: adminlayout } },

  { path:  `${prefix}/sonod/:name/:type`, component: sonod, name:'sonod',meta: { layout: adminlayout } },

  { path:  `${prefix}/sonod/action/edit/:id`, component: sonodedit, name:'sonodedit',meta: { layout: adminlayout } },
  { path:  `${prefix}/sonod/action/view/:id`, component: sonodview, name:'sonodview',meta: { layout: adminlayout } },

  { path:  `${prefix}/sonod/action/approve/:id`, component: sonodapprove, name:'sonodapprove',meta: { layout: adminlayout } },
  { path:  `${prefix}/sonod/action/approve/:id`, component: approvesonod, name:'approvesonod',meta: { layout: adminlayout } },
  { path:  `${prefix}/sonod/action/approve/trade/:id`, component: approvetrade, name:'approvetrade',meta: { layout: adminlayout } },

  { path:  `${prefix}/tags`, component: Tags, name:'tags',meta: { layout: adminlayout } },
  { path:  `${prefix}/role`, component: role, name:'role',meta: { layout: adminlayout } },

  { path:  `${prefix}/index`, component: index, name:'index',meta: { layout: adminlayout } },

  { path: "*", component: PageNotFound }

]
