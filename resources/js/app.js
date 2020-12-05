require('./bootstrap');
window.Vue = require('vue');

import { library } from '@fortawesome/fontawesome-svg-core'
import { faCaretUp, faCaretDown, faStar} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faCaretUp, faCaretDown, faStar);

Vue.component('font-awesome-icon', FontAwesomeIcon)

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
