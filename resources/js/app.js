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

// bootstrap datatable
import { TablePlugin } from 'bootstrap-vue';
Vue.use(TablePlugin);

// vuex store
import { store } from './store';

// for flash messages
import VueFlashMessage from '@smartweb/vue-flash-message';
Vue.use(VueFlashMessage);

// for form validation
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

// for common functions
import common from "./common"
Vue.mixin(common)

// Default vue component
Vue.component('main-content',require('./components/mainApp').default)
const app = new Vue({
    el : '#app',
    router,
    store : store,
})
