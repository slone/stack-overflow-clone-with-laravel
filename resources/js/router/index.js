import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';

Vue.use(VueRouter);

const router = new VueRouter({
	mode: 'history',
	routes, // or routes:routes
    linkActiveClass: 'active'
});

router.beforeEach((to, from, next) => {
	if (to.matched.some(route => route.meta.requiresAuth) && !windows.Auth.signedIn) {
		windows.location = window.Auth.url;
	}
	next();
});

export default router;