require('./bootstrap');

window.Vue = require('vue');

import VueIziToast from 'vue-izitoast';
import VueAuthorization from './authorization/authorize';
import router from './router';

Vue.use(VueIziToast);
Vue.use(VueAuthorization);

Vue.component('QuestionPage', 	require('./pages/QuestionPage').default);

const app = new Vue({
	el: '#app',
	router
});
