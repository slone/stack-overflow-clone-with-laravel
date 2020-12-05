<template>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card text-center">
				<div class="card-header">
					<ul class="nav nav-tabs card-header-tabs">
						<li class="nav-item">
							<router-link :to="{name: 'my-posts'}" class="nav-link" exact>All</router-link>
						</li>
						<li class="nav-item">
							<router-link :to="{name: 'my-posts', query: { type:'questions'}}" class="nav-link" exact>Questions</router-link>
						</li>
						<li class="nav-item">
							<router-link :to="{name: 'my-posts', query: { type:'answers'}}" class="nav-link" exact>Answers</router-link>
						</li>
					</ul>
				</div>
				<div class="card-body">
					<ul v-if="posts.length" class="list-group list-group-flush">
						<li class="list-group-item" v-for="(post, index) in posts" :key="index">
							<div class="row">
								<div class="col">
									<span class="post-badge" :class="{ 'accepted' : post.accepted }">{{ post.type }}</span>
									<span class="ml-4 votes-count" :class="{ 'accepted' : post.accepted }">{{ post.votes_count }}</span>
								</div>
								<div class="col-md-9 text-left">{{ post.title }}</div> 
								<div class="col text-right">{{ post.created_at }}</div>
							</div>
						</li>
					</ul>
					<div v-else class="alert alert-warning">
						<p>You have neither answered or asked a question, yet.</p>
						<p>
							<router-link :to="{ name: 'questions.create' }">Ask Question</router-link>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</template>
<script>
export default {
	data() {
		return {
			posts: []
		}
	},
	methods: {
		fetchPosts() {
			axios.get('/my-posts', { params: this.$route.query })
				.then( ({data}) => {
					this.posts = data.data;
				})
				.catch( ({response}) => {
					this.$toast.error(response.data.message, 'Error');
				});
		},
	},
	mounted() {
		this.fetchPosts();
	},
	watch: {
		"$route" : "fetchPosts"
	}

}
</script>
<style lang="scss" scoped>
	$color-green: rgba(95, 187, 126);
	.votes-count {
		border: 1px solid #DDD;
		display: inline-block;
		min-width: 40px;
		text-align: center;
		border-radius: .25em;
		&.accepted {
			background-color: $color-green;
			border-color: $color-green;
			color: white;
		}
	}
	.post-badge {
		border: 1px solid #DDD;
		display: inline-block;
		width: 25px;
		text-align: center;
		border-radius: 100%;

		&.accepted {
			border-color: $color-green;
			color: $color-green;
		}
	}
</style>