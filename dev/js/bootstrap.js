import Vue from 'vue';
import VueApexCharts from 'vue-apexcharts'
import uuid from 'uuid/dist/v1'
require("./utils/filters/global_filters");
window.axios = require('axios');
window.aps_globals = aps_globals_one
window.aps_globals._ = lodash;
require("./plugins/google")
window.uuid = uuid
window.Vue = Vue;
Vue.config.productionTip = false;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-WP-Nonce'] = aps_globals.token
Vue.use(VueApexCharts)
Vue.component('apexchart', VueApexCharts)
window.Papa = require("./utils/forms/Papa")

import lodash from './utils/lodash';
