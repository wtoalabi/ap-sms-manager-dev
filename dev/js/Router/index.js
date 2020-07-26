import Vue from 'vue';
import VueRouter from 'vue-router';
import Store from '../Store';
import Dashboard from "@/Pages/Dashboard/Dashboard"
import contacts from "@/Router/contacts";
import groups from "@/Router/groups";
import reports from "@/Router/reports";
import add_contacts from "@/Router/add_contacts";
import gateways from "@/Router/gateways";
import user_settings from "@/Router/settings";
import {scrollToTop} from "@/utils/helpers/documents";
import send_sms from "@/Router/send_sms";
Vue.use(VueRouter);
const router = new VueRouter({
  mode: 'hash',
  routes: [
    {
      path: '/',
      component: Dashboard,
      name: 'Dashboard',
      /*beforeEnter(to, from, next) {
          //Store.dispatch('getContent');
          next()
      }*/
      meta: {
        id: 'dashboard',
        parents:[]
      },
    },
    ...contacts,
    ...groups,
    ...reports,
    ...add_contacts,
    ...gateways,
    ...user_settings,
    ...send_sms
  ]
});
router.beforeEach((to, from, next) => {
  Store.commit("resetQueryState");
  Store.commit('setTitle', to.name);
  scrollToTop()
  next()
});
export default router
