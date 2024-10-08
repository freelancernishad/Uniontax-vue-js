let layout = require('./components/layouts/layout.vue').default;
let blank = require('./components/layouts/blank.vue').default;


let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let forget = require('./components/auth/forget.vue').default;


let certificate = require('./components/form/aftersubmit.vue').default;

// let application = require('./components/form/formwithNid.vue').default;


let application = require('./components/form/application.vue').default;
// let application = require('./components/form_pre_pay/application.vue').default;
let finalform = require('./components/form_pre_pay/applicationfinal.vue').default;


// let application = require('./components/form/form.vue').default;



let application2 = require('./components/form/form2.vue').default;

let blogs = require('./components/blogs/index.vue').default;
let blogread = require('./components/blogs/read.vue').default;

let sonodVerify = require('./components/sonodVerify.vue').default;
let sonodsearch = require('./components/sonodsearch.vue').default;
let holdingTax = require('./components/holdingTax.vue').default;
let holdingTaxSingle = require('./components/holdingTaxSingle.vue').default;
let contact = require('./components/contact.vue').default;
let upProfile = require('./components/upProfile.vue').default;
let notice = require('./components/notice.vue').default;
let tenders = require('./components/tenders.vue').default;

let home = require('./components/home.vue').default;
let reject = require('./components/reject.vue').default;

let tenderView = require('./components/tender/view.vue').default;

let citizens_corner = require('./components/citizens_corner/index.vue').default;


let case_form = require('./components/cases/form.vue').default;

let PageNotFound = require('./components/404.vue').default;


let prefix = '/'
export const routes = [
    { path:  `${prefix}`, component: home, name:'home',meta: { layout: layout } },
    { path: `${prefix}login`, component: login, name:'login',meta: { layout: blank } },
    { path:  `${prefix}register`, component: register, name:'register',meta: { layout: layout } },
    { path:  `${prefix}forget`, component: forget, name:'forget',meta: { layout: layout } },
    { path:  `${prefix}uniontax/profile`, component: upProfile, name:'upProfile',meta: { layout: layout } },
    { path:  `${prefix}notice`, component: notice, name:'notice',meta: { layout: layout } },
    { path:  `${prefix}notice/tenders`, component: tenders, name:'tenders',meta: { layout: layout } },
    { path:  `${prefix}contact`, component: contact, name:'contact',meta: { layout: layout } },
    { path:  `${prefix}holding/tax`, component: holdingTax, name:'holdingTax',meta: { layout: layout } },
    { path:  `${prefix}holding/tax/:id`, component: holdingTaxSingle, name:'holdingTaxSingle',meta: { layout: layout } },
    { path:  `${prefix}preview`, component: certificate, name:'certificate',meta: { layout: layout } },
    { path:  `${prefix}verification/sonod/:id`, component: sonodVerify, name:'sonodVerify',meta: { layout: layout } },
    { path:  `${prefix}sonod/search`, component: sonodsearch, name:'sonodsearch',meta: { layout: layout } },
    { path:  `${prefix}application/:name`, component: application, name:'application',meta: { layout: layout } },

    { path:  `${prefix}applications/final/form`, component: finalform, name:'finalform',meta: { layout: layout } },


    { path:  `${prefix}application2/:name`, component: application2, name:'application2',meta: { layout: layout } },
    { path:  `${prefix}blogs/:name`, component: blogs, name:'blogs',meta: { layout: layout } },
    { path:  `${prefix}blogs/read/:id`, component: blogread, name:'blogread',meta: { layout: layout } },
    { path:  `${prefix}reject/:id`, component: reject, name:'reject',meta: { layout: layout } },


    { path:  `${prefix}tenderview/:id`, component: tenderView, name:'tenderView',meta: { layout: layout } },

    { path:  `${prefix}citizens_corner`, component: citizens_corner, name:'citizens_corner',meta: { layout: layout } },



    { path:  `${prefix}cases/form`, component: case_form, name:'case_form',meta: { layout: layout } },

  { path: "*", component: PageNotFound }

]

