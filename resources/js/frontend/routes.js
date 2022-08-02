let layout = require('./components/layouts/layout.vue').default;
let blank = require('./components/layouts/blank.vue').default;


let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let forget = require('./components/auth/forget.vue').default;


let certificate = require('./components/form/aftersubmit.vue').default;
let application = require('./components/form/index.vue').default;

let blogs = require('./components/blogs/index.vue').default;

let sonodVerify = require('./components/sonodVerify.vue').default;
let sonodsearch = require('./components/sonodsearch.vue').default;
let contact = require('./components/contact.vue').default;

let home = require('./components/home.vue').default;
let PageNotFound = require('./components/404.vue').default;


let prefix = '/'
export const routes = [
    { path:  `${prefix}`, component: home, name:'home',meta: { layout: layout } },
    { path: `${prefix}login`, component: login, name:'login',meta: { layout: blank } },
    { path:  `${prefix}register`, component: register, name:'register',meta: { layout: layout } },
    { path:  `${prefix}forget`, component: forget, name:'forget',meta: { layout: layout } },
    { path:  `${prefix}contact`, component: contact, name:'contact',meta: { layout: layout } },
    { path:  `${prefix}preview`, component: certificate, name:'certificate',meta: { layout: layout } },
    { path:  `${prefix}verification/sonod/:id`, component: sonodVerify, name:'sonodVerify',meta: { layout: layout } },
    { path:  `${prefix}sonod/search`, component: sonodsearch, name:'sonodsearch',meta: { layout: layout } },
    { path:  `${prefix}application/:name`, component: application, name:'application',meta: { layout: layout } },
    { path:  `${prefix}blogs/:name`, component: blogs, name:'blogs',meta: { layout: layout } },

  { path: "*", component: PageNotFound }

]

