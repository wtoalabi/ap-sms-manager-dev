require("./bootstrap")
import Vue from 'vue';

window.Vue = Vue;
import store from './Store';
import router from "./Router"
import 'vuetify/dist/vuetify.min.css';
import vuetify from "./plugins/vuetify";

window.breakpoints = vuetify.framework.breakpoint;
const files = require.context('./Pages', true, /\.vue$/i);

files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
let element = document.querySelector("#apps_bay_sms_manager_dashboard")
if (element){
  new Vue({
    store,
    router,
    vuetify,
  }).$mount(  '#apps_bay_sms_manager_dashboard');

}
