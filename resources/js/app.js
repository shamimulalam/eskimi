require('./bootstrap');
window.Vue = require('vue');
import router from './router';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
//import css files
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
// Install BootstrapVue
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);

import { TablePlugin } from 'bootstrap-vue';
Vue.use(TablePlugin);

import { store } from './store';

import VueFlashMessage from '@smartweb/vue-flash-message';
Vue.use(VueFlashMessage);

import common from "./common"
Vue.mixin(common)


Vue.component('main-content',require('./components/mainApp').default)
const app = new Vue({
    el : '#app',
    router,
    store : store,
})
