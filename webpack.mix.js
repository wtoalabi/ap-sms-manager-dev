const mix = require('laravel-mix');
require('laravel-mix-purgecss');
const LiveReloadPlugin = require('webpack-livereload-plugin');
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin');
/*
 |--------------------------------------------------------------------------
 | Aliases
 |--------------------------------------------------------------------------
 */
mix.webpackConfig({
  plugins: [
    new VuetifyLoaderPlugin(),
    new LiveReloadPlugin(),
  ],
  watchOptions: {
    ignored: /node_modules/,
  },
  resolve: {
    alias: {
      '@': path.join(__dirname, 'dev/js/'),
      'node_modules': path.join(__dirname, 'node_modules')
    }
  }
}).sourceMaps();
mix.js('dev/js/app.js', 'src/Assets/js/app.js')
  .sass('dev/scss/app.scss', 'src/Assets/styles/app.css').disableSuccessNotifications();
