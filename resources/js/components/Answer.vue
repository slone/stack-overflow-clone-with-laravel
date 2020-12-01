<template>
	<div class="media post answer-wrapper">

		<vote-buttons :model="answer" name="answer"></vote-buttons>

		<div class="media-body">

			<form v-if="editing" @submit.prevent="update">
				<div class="form-group">
					<textarea required v-model="body" rows="10" class="form-control"></textarea>
				</div>
				<div class="form-group">
					<button class="btn btn-primary" type="submit" :disabled="isInvalid">Update</button>
					<button class="btn btn-outline-secondary" type="button" @click.prevent="cancel">Cancel</button>
				</div>
			</form>

			<div v-else v-html="bodyHtml"></div>

			<footer v-if="!editing" class="row answer-infos">
				<div class="col-4 owner-controls">
					<div class="ml-auto">
						<a 			v-if="authorize('modify', answer)" @click.prevent="edit" 	href="#" 		class="btn btn-sm btn-outline-info">Edit</a>
						<button 	v-if="authorize('modify', answer)" @click.prevent="destroy" type="button" 	class="btn btn-sm btn-outline-danger">Delete</button>
					</div>								
				</div>
				<div class="col-3"></div>
				<div class="col-5">
					<user-info :model="answer" label="answered"></user-info>
				</div>
			</footer>					
		</div>
	</div>
</template>

<script>
import UserInfo from './UserInfo';
import VoteButtons from './VoteButtons';
import modification from '../mixins/modification';

export default {
	props: ['answer'],
	components: {VoteButtons,UserInfo},
	mixins: [modification],
	data() {
		return {
			body: this.answer.body,
			bodyHtml: this.answer.body_html,
			id: this.answer.id,
			questionId: this.answer.question_id,
			beforeEditCache: null,
		}
	},

	computed: {
		isInvalid() {
			return this.body.length < 40;
		},
		endpoint() {
			return `/questions/${this.questionId}/answers/${this.id}`;
		}
	},

	methods: {
		setEditCache() {
			this.beforeEditCache = this.body;
		},
		restoreFromCache() {
			this.body = this.beforeEditCache;
		},
		payload() {
			return {
				body: this.body,
			};
		},
		delete() {
			axios.delete(this.endpoint)
			.then( res => {
				this.$emit('answer-deleted')
			})
			.catch( ({ response }) => {
				this.$toast.error(response.data.message, 'Error',  { timeout: 4000 });
			});
		},
	}
}
</script>