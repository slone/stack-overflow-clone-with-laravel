require('./bootstrap');
window.Vue = require('vue');

import { library } from '@fortawesome/fontawesome-svg-core'
import { faCaretUp, faCaretDown, faStar, faSpinner} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faCaretUp, faCaretDown, faStar, faSpinner);

Vue.component('font-awesome-icon', FontAwesomeIcon)

import VueIziToast from 'vue-izitoast';
import VueAuthorization from './authorization/authorize';
import router from './router';
import LoadingSpinner from './components/LoadingSpinner';

Vue.use(VueIziToast);
Vue.use(VueAuthorization);

Vue.component('LoadingSpinner', LoadingSpinner);

const app = new Vue({
	el: '#app',
	data: {
		isLoading: true,
		interceptorRequest: null,
		interceptorResponse: null,
	},
	router,

	methods: {
		enableAxiosInterceptors() {
			// Request Interceptors
			this.interceptorRequest = axios.interceptors.request.use((config) => {
				this.isLoading = true
				return config;
			},
			(error) => {
				this.isLoading = false;
				return Promise.reject(error);
			});

			// Response Interceptors
			this.interceptorResponse = axios.interceptors.response.use((response) => {
				this.isLoading = false;
				return response;
			},
			(error) => {
				this.isLoading = false;
				return Promise.reject(error);
			})
		},
        disableAxiosInterceptors() {
            axios.interceptors.request.eject(this.interceptorRequest);
            axios.interceptors.response.eject(this.interceptorResponse);
        }
 	},
	created() {
		this.enableAxiosInterceptors();
	}
});
