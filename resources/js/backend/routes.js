let adminlayout = require('./components/layouts/adminlayout.vue').default;
let blanklayout = require('./components/layouts/blanklayout.vue').default;



// Auth Components

let logout = require('./components/auth/logout.vue').default;

let home = require('./components/home.vue').default;
let unionprofile = require('./components/unionprofile.vue').default;
let charages = require('./components/charages.vue').default;
let profile = require('./components/profile.vue').default;

let cashbook = require('./components/cashbook/list.vue').default;
let cashbookForm = require('./components/cashbook/form.vue').default;

let report = require('./components/report.vue').default;
// let onlinereport = require('./components/onlinereport.vue').default;
let sonodcountall = require('./components/sonodcountall.vue').default;

let userlist = require('./components/users/list.vue').default;
let userlistedit = require('./components/users/form.vue').default;

let citizenlist = require('./components/citizen/list.vue').default;
let citizenadd = require('./components/citizen/form.vue').default;

let sonodFees = require('./components/sonodList/sonodfee.vue').default;

let sonodlist = require('./components/sonodList/list.vue').default;
let sonodlistedit = require('./components/sonodList/form.vue').default;

let unionlist = require('./components/unionList/list.vue').default;
let unionlistedit = require('./components/unionList/form.vue').default;

let sonod = require('./components/sonod/index.vue').default;
let sonodedit = require('./components/sonod/form.vue').default;
let sonodview = require('./components/sonod/view.vue').default;

let sonodapprove = require('./components/sonod/approve.vue').default;
let approvesonod = require('./components/sonod/approvesonod.vue').default;
let approvetrade = require('./components/sonod/approvetrade.vue').default;

let Tags = require('./components/Tags/index.vue').default;
let role = require('./components/assignRole.vue').default;

let index = require('./components/vuex/index.vue').default;



let holdingTaxWord = require('./components/holdingTax/word.vue').default;
let holdingTaxList = require('./components/holdingTax/list.vue').default;
let holdingTaxedit = require('./components/holdingTax/form.vue').default;
let holdingTaxView = require('./components/holdingTax/view.vue').default;

//blogs
let blogs = require('./components/blogs/list.vue').default;
let blogform = require('./components/blogs/form.vue').default;
//category
let category = require('./components/blogs/category/list.vue').default;
let categoryform = require('./components/blogs/category/form.vue').default;

let PageNotFound = require('./components/404.vue').default;


let prefix = '/dashboard'
export const routes = [

  //Auth Routes

  { path: `${prefix}/logout`, component: logout, name:'logout',meta: { layout: blanklayout } },

  { path:  `${prefix}`, component: home, name:'Dashboard',meta: { layout: adminlayout } },
  { path:  `${prefix}/profile`, component: profile, name:'profile',meta: { layout: adminlayout } },
  { path:  `${prefix}/union/profile`, component: unionprofile, name:'unionprofile',meta: { layout: adminlayout } },
  { path:  `${prefix}/union/charges`, component: charages, name:'charages',meta: { layout: adminlayout } },


  { path:  `${prefix}/report`, component: report, name:'report',meta: { layout: adminlayout } },
//   { path:  `${prefix}/online/payment/report`, component: onlinereport, name:'onlinereport',meta: { layout: adminlayout } },


  { path:  `${prefix}/sonodcountall`, component: sonodcountall, name:'sonodcountall',meta: { layout: adminlayout } },


  { path:  `${prefix}/cashbook/list`, component: cashbook, name:'cashbook',meta: { layout: adminlayout } },
  { path:  `${prefix}/cashbook/fomm`, component: cashbookForm, name:'cashbookForm',meta: { layout: adminlayout } },
  { path:  `${prefix}/cashbook/edit/:id`, component: cashbookForm, name:'cashbookFormEdit',meta: { layout: adminlayout } },


  { path:  `${prefix}/user/list`, component: userlist, name:'userlist',meta: { layout: adminlayout } },
  { path:  `${prefix}/user/list/add`, component: userlistedit, name:'userlistadd',meta: { layout: adminlayout } },
  { path:  `${prefix}/user/list/edit/:id`, component: userlistedit, name:'userlistedit',meta: { layout: adminlayout } },



  { path:  `${prefix}/holding/tax/words`, component: holdingTaxWord, name:'holdingTaxWord',meta: { layout: adminlayout } },
  { path:  `${prefix}/holding/tax/list/:word`, component: holdingTaxList, name:'holdingTaxList',meta: { layout: adminlayout } },
  { path:  `${prefix}/holding/list/view/:id`, component: holdingTaxView, name:'holdingTaxView',meta: { layout: adminlayout } },
  { path:  `${prefix}/holding/list/add/:wordNo`, component: holdingTaxedit, name:'holdingTaxadd',meta: { layout: adminlayout } },
  { path:  `${prefix}/holding/list/edit/:id`, component: holdingTaxedit, name:'holdingTaxedit',meta: { layout: adminlayout } },


  { path:  `${prefix}/citizen/list`, component: citizenlist, name:'citizenlist',meta: { layout: adminlayout } },
  { path:  `${prefix}/citizen/add`, component: citizenadd, name:'citizenadd',meta: { layout: adminlayout } },
  { path:  `${prefix}/citizen/edit/:id`, component: citizenadd, name:'citizenedit',meta: { layout: adminlayout } },

  { path:  `${prefix}/sonod/fee`, component: sonodFees, name:'sonodFees',meta: { layout: adminlayout } },

  { path:  `${prefix}/sonod/list`, component: sonodlist, name:'sonodlist',meta: { layout: adminlayout } },
  { path:  `${prefix}/sonod/list/add`, component: sonodlistedit, name:'sonodlistadd',meta: { layout: adminlayout } },
  { path:  `${prefix}/sonod/list/edit/:id`, component: sonodlistedit, name:'sonodlistedit',meta: { layout: adminlayout } },

  { path:  `${prefix}/union/list`, component: unionlist, name:'unionlist',meta: { layout: adminlayout } },
  { path:  `${prefix}/union/list/add`, component: unionlistedit, name:'unionlistadd',meta: { layout: adminlayout } },
  { path:  `${prefix}/union/list/edit/:id`, component: unionlistedit, name:'unionlistedit',meta: { layout: adminlayout } },

  { path:  `${prefix}/sonod/:name/:type`, component: sonod, name:'sonod',meta: { layout: adminlayout } },

  { path:  `${prefix}/sonod/action/edit/:id`, component: sonodedit, name:'sonodedit',meta: { layout: adminlayout } },
  { path:  `${prefix}/sonod/action/view/:id`, component: sonodview, name:'sonodview',meta: { layout: adminlayout } },

  { path:  `${prefix}/sonod/action/approve/:id`, component: sonodapprove, name:'sonodapprove',meta: { layout: adminlayout } },
  { path:  `${prefix}/sonod/action/approve/:id`, component: approvesonod, name:'approvesonod',meta: { layout: adminlayout } },
  { path:  `${prefix}/sonod/action/approve/trade/:id`, component: approvetrade, name:'approvetrade',meta: { layout: adminlayout } },

  { path:  `${prefix}/tags`, component: Tags, name:'tags',meta: { layout: adminlayout } },
  { path:  `${prefix}/role`, component: role, name:'role',meta: { layout: adminlayout } },

  { path:  `${prefix}/index`, component: index, name:'index',meta: { layout: adminlayout } },

//blogs
  { path:  `${prefix}/blogs`, component: blogs, name:'blogs',meta: { layout: adminlayout } },
  { path:  `${prefix}/blogs/add`, component: blogform, name:'blogform',meta: { layout: adminlayout } },
  { path:  `${prefix}/blogs/edit/:id`, component: blogform, name:'blogedit',meta: { layout: adminlayout } },

//category
  { path:  `${prefix}/category`, component: category, name:'category',meta: { layout: adminlayout } },
  { path:  `${prefix}/category/add`, component: categoryform, name:'categoryform',meta: { layout: adminlayout } },
  { path:  `${prefix}/category/edit/:id`, component: categoryform, name:'categoryedit',meta: { layout: adminlayout } },


  { path: "*", component: PageNotFound }

]
