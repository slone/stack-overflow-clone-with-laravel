<template>
	<div class="accept-button">
	<a v-if="canAcceptAnswer" title="Mark as best answer" :class="statusClasses" @click.prevent="create"><i class="fas fa-check fa-2x"></i></a>
	<a v-if="isAcceptedAnswer" 	title="The question owner accepted this answer" :class="statusClasses" @click.prevent><i class="fas fa-check fa-2x"></i></a>
	</div>
</template>

<script>
export default {
	props: ['answer'],
	data() {
		return {
			isBest: this.answer.is_best,
			id: this.answer.id,
		}
	},
	methods: {
		create() {
			axios.post(this.endpoint)
				.then( res=> {
					this.$toast.success(res.data.message, "Success", {
						timeout: 3000,
						position: "bottomLeft"
					});
					this.isBest = !this.isBest;
				})
				.catch( err=> {
					this.$toast.error(err.response.data.message, 'Error', { timeout: 3000 });
				})
		}
	},
	computed: {
		endpoint() {
			return `/answers/${this.id}/accept`;
		},
		canAcceptAnswer() {
			return this.authorize('accept', this.answer);
		},
		isAcceptedAnswer() {
			return !this.canAcceptAnswer && this.isBest;
		},
		statusClasses() {
			return ["mt-2",	this.isBest ? "vote-accepted" : ""	];
		}
	},
}
</script>