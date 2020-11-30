<template>
	<div class="media post answer-wrapper">
		<div class="row">

			<vote-buttons :model="answer" name="answer"></vote-buttons>
	
			<div class="media-body">
				<form v-if="editing" class="answer-form-size-quick-fix" @submit.prevent="update">
					<div class="form-group">
						<textarea required v-model="body" rows="10" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit" :disabled="isInvalid">{{ __('Update') }}</button>
						<button class="btn btn-outline-secondary" type="button" @click.prevent="cancel">{{ __('Cancel') }}</button>
					</div>
				</form>
				<div v-else>

					<div v-html="bodyHtml"></div>

					<footer class="row answer-infos">
						<div class="col-4 owner-controls">
							<div class="ml-auto">
								<a 			v-if="authorize('modify', answer)" @click.prevent="edit" href="#" class="btn btn-sm btn-outline-info">{{ __('Edit') }}</a>
								<button 	v-if="authorize('modify', answer)" type="button" class="btn btn-sm btn-outline-danger" @click.prevent="destroy">{{ __('Delete') }}</button>
							</div>								
						</div>
						<div class="col-3"></div>
						<div class="col-5">
							<user-info :model="answer" label="answered"></user-info>
						</div>
					</footer>					

				</div>
			</div>
		</div>
	</div>
</template>

<script>
import VoteButtons from './VoteButtons.vue';

export default {
	props: ['answer'],
	components: {VoteButtons},
	data() {
		return {
			editing: false,
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
		edit() {
			this.editing = true;
			this.beforeEditCache = this.body;
		},
		cancel() {
			this.editing = false;
			this.body = this.beforeEditCache;
		},
		update() {

			axios.patch(this.endpoint, {
				body: this.body,
			})
			.then(res => {
				this.bodyHtml = res.data.body_html;
				this.editing=false;
				this.$toast.success(err.response.data.message, 'Success', { timeout: 3000 });
			})
			.catch(err => {
				console.error(err.response.data.message);
				this.$toast.error(err.response.data.message, 'Error', { timeout: 3000 });
			});
		},
		destroy() {
			this.$toast.question('<p>Are you sure you wish to delete this answer?</p>\r\n<p><strong>This cannot be undone!</strong></p>', 'Confirm deletion', {
				timeout: 20000,
				close: false,
				overlay: true,
				displayMode: 'once',
				id: 'question',
				zindex: 999,
				title: 'Hey',
				position: 'center',
				buttons: [
					['<button><b>YES</b></button>', (instance, toast) => {
						axios.delete(this.endpoint)
						.then( res => {
							$(this.$el).fadeOut(500, () => {
								this.$toast.success(res.data.message, 'Success', { timeout: 3000 });
							})
						});

						instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

					}, true],
					['<button>NO</button>', function (instance, toast) {

						instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

					}],
				],
			});
		}
	}
}
</script>