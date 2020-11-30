<template>
	<a title="Click to favorite the question - click again to undo" :class="classes" @click.prevent="toggleFavorite">
		<i class="fas fa-star fa-2x"></i>
		<span class="favorites-count">{{ count }}</span>
	</a>
</template>

<script>
export default {
	props: ["question"],
	data() {
		return {
			isFavorited: this.question.is_favorited,
			count: this.question.favorites_count,
			id: this.question.id,
		}
	},
	computed: {
		classes() {
			return [
				"favorite", "mt-2", 
				! this.signedIn ? "off" : (this.isFavorited ? "favorited" : "")
			];
		},
		endpoint() {
			return `/questions/${this.id}/favorites`;			
		}
	},
	methods: {
		toggleFavorite() {
			if (! this.signedIn) 
			 	this.$toast.warning("You need to be logged in to be able to add a question to your favorite", "Warning", { 
					 timeout: 3000, position: "bottomLeft" 
				});
			else 
				this.isFavorited ? this.destroyFavorite() : this.createFavorite();
		},
		destroyFavorite() {
			axios.delete(this.endpoint) 
			.then(res => {
				this.count--;
				this.isFavorited = false;
				this.$toast.success("Question is no longer a favorite.", "Success", { timeout: 3000 });
			})
			.catch(err => {
				this.$toast.error(err.response.data.message, "Error", { timeout: 3000 });
			})
		},
		createFavorite() {
			axios.post(this.endpoint) 
			.then(res => {
				this.count++;
				this.isFavorited = true;
				this.$toast.success("Question has been added to your favorite.", "Success", { timeout: 3000 });
			})
			.catch(err => {
				this.$toast.error(err.response.data.message, "Error", { timeout: 3000 });
			})
		}
	}
}
</script>