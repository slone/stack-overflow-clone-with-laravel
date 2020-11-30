<template>
<div class="d-flex flex-column vote-controls">

	<a @click.prevent="voteUp()" 		:title="title('up')" 	class="vote-up" 	:class="voteClasses"><i class="fas fa-caret-up fa-2x"></i></a>
	<span class="votes-count">{{ count }}</span>
	<a @click.prevent="voteDown()"  	:title="title('down')" 	class="vote-down" 	:class="voteClasses"><i class="fas fa-caret-down fa-2x"></i></a>

	<favorite-button 	v-if="name==='question'" 	:question="model"></favorite-button>
	<accept-button 		v-if="name==='answer'" 		:answer="model"></accept-button>	
</div>
</template>

<script>
import FavoriteButton from './FavoriteButton.vue';
import AcceptButton from './AcceptButton.vue';

export default {
	props: ['name', 'model'],
	components: {FavoriteButton, AcceptButton},
	data() {
		return {
			count: this.model.votes_count || 0,
			id: this.model.id,
		}
	},
	computed: {
		voteClasses() {
			return this.signedIn ? '' : 'off';
		},
		endpoint() {
			return `/${this.name}s/${this.id}/vote`;
		}
	},
	methods: {
		title(voteType) {
			let titles = {
				up: `this ${this.name} is useful`,
				down: `this ${this.name} is not useful`
			}
			return titles[voteType];
		},

		voteUp() 	{	this._vote(1); 		},
		voteDown() 	{ 	this._vote(-1); 	},

		_vote(voteValue) {
			if (!this.signedIn) {
				return this.$toast.warning(`Please login to vote for this ${this.name}`, 'Warning', {
					timeout: 3000,
					position: "bottomLeft",
				})
			}
			axios.post(this.endpoint, { vote:voteValue })
			.then(res => {
				this.$toast.success(res.data.message, "Success",  {
					timeout: 3000,
					position: "bottomLeft",
				});

				this.count = res.data.votesCount
				console.log(this.count);
			})
			.catch(err => {
				this.$toast.error(err.response.data.message, "Error", {
					timeout: 3000,
					position: "bottomLeft"
				})
			})
		},
	}
}
</script>