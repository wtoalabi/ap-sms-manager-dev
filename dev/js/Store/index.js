import Vue from 'vue';
import Vuex from 'vuex';
import actions from './Actions/actions';
import mutations from './Mutators/mutators';
import state from "./State/states";
Vue.use(Vuex);

export  default new Vuex.Store({
  actions,
  mutations,
  state
});
