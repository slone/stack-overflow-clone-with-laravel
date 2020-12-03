<template>
<div class="container">
	<div class="jumbotron text-center">
		<h1 class="display-4">Page not found</h1>
		<p class="lead">The page you're looking doesn't exists (any longer?).</p>
		<hr class="my-4">
		<router-link class="btn btn-primary btn-lg" :to="{ name: 'home' }" role="link">Take me home!</router-link>
	</div>
</div>
</template>