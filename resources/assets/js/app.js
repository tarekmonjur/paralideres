
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./pnotify');
require('./loading_overlay.min');
require('./owl.carousel');
require('./main');

window.Vue = require('vue');

import Common from './common';
Vue.use(Common);

window.base_url = 'http://paralideres.dev:8000/';
window.api_url = 'api/v1/';

window.grant_type = 'password';
window.client_id = 2;
window.client_secret = 'fxSJObgD3uj91OkN2S8TcNO5gpXu8TB0tj6zZZTw';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));
