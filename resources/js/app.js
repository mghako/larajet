

require('./bootstrap');

window.Vue = require('vue')
window.Start = new Vue()
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import { Form, HasError, AlertError } from 'vform'
import VueProgressBar from 'vue-progressbar'
import swal from 'sweetalert2'
import Gate from './Gate'
Vue.prototype.$gate = new Gate(window.user)
// using vform


Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

window.Form = Form

// end vform 
// using progressbar


Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '6px'
})
// end progressbar
// Alert
window.swal = swal

let toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  })
window.toast = toast
// End Alert

let routes = [
    { path: '/users', component: require('./components/Users.vue')},
    { path: '/dashboard', component: require('./components/Dashboard.vue')},
    { path: '/jobs', component: require('./components/Jobs.vue')},
    { path: '/company', component: require('./components/Company.vue')},
    { path: '/profile', component: require('./components/Profile.vue')},
    { path: '/reports', component: require('./components/Reports.vue')},
    { path: '/token', component: require('./components/Token.vue')}
]

let router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);
Vue.component(
    'not-found',
    require('./components/NotFound.vue')
  );
Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    router
});
