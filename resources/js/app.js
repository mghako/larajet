

require('./bootstrap');

window.Vue = require('vue')
window.Start = new Vue()
import VueRouter from 'vue-router'
Vue.use(VueRouter)

let routes = [
    { path: '/users', component: require('./components/Users.vue')},
    { path: '/dashboard', component: require('./components/Dashboard.vue')},
    { path: '/jobs', component: require('./components/Jobs.vue')},
    { path: '/company', component: require('./components/Company.vue')},
    { path: '/profile', component: require('./components/Profile.vue')},
    { path: '/reports', component: require('./components/Reports.vue')}
]

let router = new VueRouter({
    mode:'history',
    routes // short for `routes: routes`
})



Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    router
});
