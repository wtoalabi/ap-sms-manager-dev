// src/plugins/vuetify.js
import "../../scss/fonts/mdi_font-face.css"
import Vue from 'vue'
import Vuetify from 'vuetify/lib'

Vue.use(Vuetify);

const opts = {
  theme: {
    themes: {
      light: {
        primary: '#1E88E5',
        secondary: '#FAFAFA',
        success: "#4baf50",
        accent: '#0097A7',
        error: '#b71c1c',
        info:'#1E88E5'
      },
      dark: {
        primary: '#1E88E5',
        secondary: '#424242',
        accent: '#0097A7',
        error: '#b71c1c',
      },
    },
  },
  icons: {
    iconfont: 'mdi', // 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4' || 'faSvg'
  },
};

export default new Vuetify(opts)
