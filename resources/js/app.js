/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');
import vue from 'vue'
window.Vue = vue;
window.axios = require('axios');
import vueCountryRegionSelect from 'vue-country-region-select'


Vue.use(vueCountryRegionSelect)
window.Vue = require('vue').default;

// window.flash = function (message) {
//     window.events.$emit('flash', message);
// }
import { initializeApp } from "firebase/app";
const firebaseApp = initializeApp({
    apiKey: "AIzaSyD1kV-JuRfm6kUOTetE1wfTVeJ6bAub794",
    authDomain: "bettingapp-70c54.firebaseapp.com",
    projectId: "bettingapp-70c54",
    storageBucket: "bettingapp-70c54.appspot.com",
    messagingSenderId: "783256496504",
    appId: "1:783256496504:web:59a128fe40aee4ff65808d",
    measurementId: "G-R5KWDGW5YE"
});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
import VueRouter from 'vue-router';
Vue.use(VueRouter);
// import VueRouter from 'vue-router';
// import { routes } from './routes';
// Vue.use(VueRouter);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import { BSpinner } from "bootstrap-vue";
Vue.component("b-spinner", BSpinner);
import { BFormFile } from 'bootstrap-vue'
Vue.component('b-form-file', BFormFile)
// import { ToastPlugin } from 'bootstrap-vue'
// Vue.use(ToastPlugin)


import "datatables.net-bs4";
import "datatables.net-bs4/css/dataTables.bootstrap4.min.css";
import "jszip";
import "datatables.net-buttons-bs4";
import "datatables.net-responsive-bs4";



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('dashboard', require('./components/index.vue').default);
/**
 * Dashboard
 */
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('datatable-component', require('./components/DataTableComponent.vue').default);
Vue.component('list-component', require('./components/user/list.vue').default);
Vue.component('add-component', require('./components/user/add.vue').default);
Vue.component('edit-component', require('./components/user/edit.vue').default);
Vue.component('view-component', require('./components/user/view.vue').default);
Vue.component('match-component', require('./components/user/match.vue').default);
/**
 * Category Components
 */
import CreateComponent from './components/category/add.vue';
Vue.component('category-list', require('./components/category/list.vue').default);
Vue.component('category-add', require('./components/category/add.vue').default);
Vue.component('category-edit', require('./components/category/edit.vue').default);
/**
 * Category Components
 */
/**
 * Teams Components
 */
Vue.component('team-list', require('./components/team/list.vue').default);
Vue.component('team-add', require('./components/team/add.vue').default);
Vue.component('team-edit', require('./components/team/edit.vue').default);
/**
 * Teams Components
 */
/**
 * Match Components
 */
Vue.component('match-list', require('./components/match/list.vue').default);
Vue.component('match-add', require('./components/match/add.vue').default);
Vue.component('match-edit', require('./components/match/edit.vue').default);
/**
 * Match Components
 */
/**
 * Betting Components
 */
Vue.component('betting-list', require('./components/betting/list.vue').default);
/**
 * Betting Components
 */
Vue.component('point-list', require('./components/point/list.vue').default);
Vue.component('point-view', require('./components/point/view.vue').default);
Vue.component('withdraw', require('./components/point/withdraw-list.vue').default);
Vue.component('withdraw_view', require('./components/point/withdraw-view.vue').default);
/**
 * point Components
 */

window.Laravel = {
    "csrfToken": "foo",
    "baseUrl": window.location.origin + "/betting/public/"
    // "baseUrl": "http://hnapp.is/betting/public/"
    // "baseUrl": "http://localhost/betting/public/"
};
// const routes = [
//     {
//         name: 'create',
//         path: 'http://localhost/betting/public/category_add',
//         component: CreateComponent
//     },
// ];

// const router = new VueRouter({ mode: 'history', routes: routes });
//   const app = new Vue(Vue.util.extend({ router }, App)).$mount('#app');
// Initialize Cloud Firestore through Firebase
Vue.config.productionTip = false
const app = new Vue({
    el: '#app',
    // router: router,
});

// var example1 = new Vue({
//     el: '#example-1',
//     data: {
//         info: {},
//     }
//     ,
//     mounted() {
//         axios
//             .get('http://localhost/betting/public/showAll')
//             .then(response => (this.info = response))
//     }
// });


